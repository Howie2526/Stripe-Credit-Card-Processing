<?php

/* hide
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_POST['form-title']='Credit Card Donation';
$_POST['middle-name']='';
$_POST['name']='John Doe';
$_POST['email-address']='test@test.com';
$_POST['donation']='5';
$_POST['stripeToken']='Test';
/* hide */

if((isset($_POST['form-title']))&&(isset($_POST['middle-name']))&&(isset($_POST['name']))&&(isset($_POST['email-address']))&&(isset($_POST['donation']))&&(isset($_POST['stripeToken']))){
	$FormTitle=$_POST['form-title'];
	$MiddleName=$_POST['middle-name'];
	$Name=$_POST['name'];
	$EmailAddress=$_POST['email-address'];
	$Donation=$_POST['donation'];
	$StripeToken=$_POST['stripeToken'];
	$DonationURL='"'.$BaseURL.'credit-card-donation/"';
	
	$Name=filter_var($Name,FILTER_SANITIZE_STRING);
	$EmailAddress=filter_var($EmailAddress,FILTER_SANITIZE_EMAIL);
	$NameLength=strlen($Name);
	$EmailAddressLength=strlen($EmailAddress);
	
	if($FormTitle!='Credit Card Donation'){
		$body="<p>We have detected some unusual activity, Form Title is not in the correct format, please enable javascript and resubmit your donation.</p><p><a href={$DonationURL}>Return to Donation Page</a>.</p>";
	}else if($MiddleName!=''){
		$body="<p>We have detected some unusual activity, Middle Name is not in the correct format, please enable javascript and resubmit your donation.</p><p><a href={$DonationURL}>Return to Donation Page</a>.</p>";
	}else if(empty($Name)){
		$body="<p>We have detected some unusual activity, Name is required, please enable javascript and resubmit your donation.</p><p><a href={$DonationURL}>Return to Donation Page</a>.</p>";
	}else if(($NameLength<2)||($NameLength>64)){
		$body="<p>We have detected some unusual activity, Name is not in the correct format, please enable javascript and resubmit your donation.</p><p>Name must have minimum 2 characters and maximum 64.</p><p><a href={$DonationURL}>Return to Donation Page</a>.</p>";
	}else if((!filter_var($EmailAddress,FILTER_VALIDATE_EMAIL))||($EmailAddressLength>64)){
		$body="<p>We have detected some unusual activity, Email Address is not in the correct format, please enable javascript and resubmit your donation.</p><p>Email Address has a maximum character limit of 64.</p><p><a href={$DonationURL}>Return to Donation Page</a>.</p>";
	}else if((!ctype_digit($Donation))||($Donation<5)||($Donation>1000)){
		$body="<p>We have detected some unusual activity, Donation is not in the correct format, please enable javascript and resubmit your donation.</p><p>Minimum donation is $5 and maximum donation is $1000, no cents please.</p><p><a href={$DonationURL}>Return to Donation Page</a>.</p>";
	}else{
		$Donation=$Donation*100;
		require_once("{$Root}libraries\stripe\init.php");
		if($ReqSer==='localhost'){
			\Stripe\Stripe::setApiKey('censored');
		}else{
			\Stripe\Stripe::setApiKey('censored');
		}
		
		try{
			$PaymentMethod=\Stripe\PaymentMethod::create([
				'type'=>'card',
				'billing_details'=>[
					'email'=>$EmailAddress,
					'name'=>$Name,
				],
				'card'=>[
					'token'=>$StripeToken,
				],
			]);
			$PaymentIntent=\Stripe\PaymentIntent::create([
				'amount'=>$Donation,
				'confirm'=>'true',
				'currency'=>'cad',
				'payment_method'=>$PaymentMethod->id,
				'receipt_email'=>$EmailAddress,
			]);
			$body="<p>Thank you for your very generous donation</p>";
		}catch(\Stripe\Exception\CardException $e){
			$body="<p>We apologize for the inconvenience but your credit card was declined.</p>";
		}catch(\Stripe\ExceptionRateLimitException $e){
			$body="<p>RateLimitException</p>";
		}catch(\Stripe\ExceptionInvalidRequestException $e){
			$body="<p>InvalidRequestException</p>";
		}catch(\Stripe\ExceptionAuthenticationException $e){
			$body="<p>AuthenticationException</p>";
		}catch(\Stripe\ExceptionApiConnectionException $e){
			$body="<p>ApiConnectionException</p>";
		}catch(\Stripe\ExceptionApiErrorException $e){
			$body="<p>ApiErrorException</p>";
		}catch(Exception $e){
			$body="<p>Exception</p>";
		}
	}
}else{
	ob_start();
	include('form.php');
	$body=ob_get_contents();
	ob_end_clean();
}

?>

<!doctype html>
<html lang="en">
	<head>
		<?php
		if($ReqSer==='cdunion.ca'){
			include("{$Root}common/google-analytics.php");
		}
		?>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/bbe1b77f5f.js" crossorigin="anonymous"></script>
		<script src="https://js.stripe.com/v3/"></script>
		<script src="<?=$BaseURL;?>common/credit-card-input.php" defer></script>
		<script src="<?=$BaseURL;?>common/validation.php"></script>
		<link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" crossorigin="anonymous" rel="stylesheet">
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" rel="stylesheet">
		<link rel="preconnect" href="https://m.stripe.com/" crossorigin>
		<link rel="preconnect" href="https://kit-free.fontawesome.com" crossorigin="anonymous">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta name="robots" content="noindex,nofollow">
		<title>Credit Card Donation - The Canadian Disability Union</title>
	</head>
	<body>
		<div class="container">
			<header>
				<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
					<span class="navbar-brand mb-0 h1">CDUnion.ca</span>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNavDropdown">
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link" href="<?=$BaseURL;?>"><i class="fas fa-home"></i> &nbsp;Home</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<a class="dropdown-item" href="<?=$BaseURL;?>programs/">Programs</a>
									<a class="dropdown-item" href="<?=$BaseURL;?>disability-facts/">Facts</a>
									<a class="dropdown-item" href="<?=$BaseURL;?>what-percentage-of-adults-are-disabled/">Survey</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Other</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<a class="dropdown-item" href="<?=$BaseURL;?>news/">News</a>
									<a class="dropdown-item" href="<?=$BaseURL;?>help-wanted/">Help Wanted</a>
									<a class="dropdown-item" href="<?=$BaseURL;?>sponsors/">Sponsors</a>
									<a class="dropdown-item" href="<?=$BaseURL;?>contact-us/">Contact Us</a>
									<a class="dropdown-item" href="<?=$BaseURL;?>about-us/">About Us</a>
									<a class="dropdown-item" href="<?=$BaseURL;?>privacy-policy/">Privacy Policy</a>
									<a class="dropdown-item" href="<?=$BaseURL;?>social-media/">Social Media</a>
								</div>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=$BaseURL;?>donate/"><i class="fas fa-donate"></i> &nbsp;Please Donate</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=$BaseURL;?>newsletter/">Newsletter Signup</a>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<main>
				<h2>Credit Card Donation</h2>
				<?=$body;?>
			</main>
			<div class="filler">
			</div>
			<footer>
				<div class="navbar navbar-dark bg-primary align-text-bottom">
					<span class="navbar-text">Copyright 2020 &nbsp;||&nbsp; Website created by Harold Indoe</span>
					<span class="navbar-text"><a href="https://twitter.com/DisabilityUnion"><i class="fab fa-twitter fa-2x"></i></a> &nbsp;&nbsp;<a href="https://www.facebook.com/CanadianDisabilityUnion/"><i class="fab fa-facebook-square fa-2x"></i></a></span>
				</div>
			</footer>
		</div>
		<link href="<?=$BaseURL;?>common/css.php?v=1.08" rel="stylesheet">
	</body>
</html>
