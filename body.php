<?php

/* hide
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
hide */

if (isset($_POST['form-title'])) {
	$array = array(
		'form-title' => $_POST['form-title'],
		'middle-name' => $_POST['middle-name'],
		'first-name' => $_POST['first-name'],
		'last-name' => $_POST['last-name'],
		'donation-amount' => $_POST['donation-amount'],
		'email-address' => $_POST['email-address'],
		'unit' => $_POST['unit'],
		'address' => $_POST['address'],
		'city' => $_POST['city'],
		'province' => $_POST['province'],
		'country' => $_POST['country'],
	);
	$token = $_POST['stripeToken'];
	$body = '';
	if ((!isset($array['form-title'])) || $array['form-title'] != 'Credit Card Donation') {
		$body = $body . '<p>We have detected some suspicious activity, Form Title is not in the correct format.</p>';
	}
	if ((!isset($array['middle-name'])) || (!empty($array['middle-name']))) {
		$body = $body . '<p>We have detected some suspicious activity, Middle Name is not in the correct format.</p>';
	}
	if (isset($array['first-name'])) {
		$array['first-name'] = filter_var($array['first-name'], FILTER_SANITIZE_STRING);
	}
	if ((!isset($array['first-name'])) || (empty($array['first-name']))) {
		$body = $body . '<p>We have detected some suspicious activity, First Name is not in the correct format.</p>';
	}
	if (isset($array['last-name'])) {
		$array['last-name'] = filter_var($array['last-name'], FILTER_SANITIZE_STRING);
	}
	if ((!isset($array['last-name'])) || (empty($array['last-name']))) {
		$body = $body . '<p>We have detected some suspicious activity, Last Name is not in the correct format.</p>';
	}
	if (isset($array['donation-amount'])) {
		$array['donation-amount'] = filter_var($array['donation-amount'], FILTER_VALIDATE_INT);
	}
	if ((!isset($array['donation-amount'])) || (empty($array['donation-amount']))) {
		$body = $body . '<p>We have detected some suspicious activity, Donation Amount is not in the correct format.</p>';
	}
	if (isset($array['email-address'])) {
		$array['email-address'] = filter_var($array['email-address'], FILTER_SANITIZE_EMAIL);
	}
	if ((!isset($array['email-address'])) || (empty($array['email-address']))) {
		$body = $body . '<p>We have detected some suspicious activity, Email Address is not in the correct format.</p>';
	} else if (!filter_var($array['email-address'], FILTER_VALIDATE_EMAIL)) {
		$body = $body . '<p>' . $array['email-address'] . ' is not considered valid email address.</p>';
	}
	if (isset($array['unit'])) {
		$array['unit'] = filter_var($array['unit'], FILTER_SANITIZE_STRING);
	}
	if (!isset($array['unit'])) {
		$body = $body . '<p>We have detected some suspicious activity, Unit # is not in the correct format.</p>';
	}
	if (isset($array['address'])) {
		$array['address'] = filter_var($array['address'], FILTER_SANITIZE_STRING);
	}
	if ((!isset($array['address'])) || (empty($array['address']))) {
		$body = $body . '<p>We have detected some suspicious activity, Address is not in the correct format.</p>';
	}
	if (isset($array['city'])) {
		$array['city'] = filter_var($array['city'], FILTER_SANITIZE_STRING);
	}
	if ((!isset($array['city'])) || (empty($array['city']))) {
		$body = $body . '<p>We have detected some suspicious activity, City is not in the correct format.</p>';
	}
	if (isset($array['province'])) {
		$array['province'] = filter_var($array['province'], FILTER_SANITIZE_STRING);
	}
	if ((!isset($array['province'])) || (empty($array['province']))) {
		$body = $body . '<p>We have detected some suspicious activity, Province is not in the correct format.</p>';
	}
	if (isset($array['country'])) {
		$array['country'] = filter_var($array['country'], FILTER_SANITIZE_STRING);
	}
	if ((!isset($array['country'])) || (empty($array['country']))) {
		$body = $body . '<p>We have detected some suspicious activity, Country is not in the correct format.</p>';
	}
	if (empty($body)) {
		$name = $array['first-name'] . " " . $array['last-name'];
		if (empty($array['unit'])) {
			$address = $array['address'];
		} else {
			$address = $array['unit'] . "-" . $array['address'];
		}
		$amount = $array['donation-amount'] . '00';
		if ($server === 'localhost') {
			require 'C:\\xampp\composer\vendor\autoload.php';
		} else {
			require '/home2/cdunionc/php/composer/vendor/autoload.php';
		}
		// \Stripe\Stripe::setApiKey('censored');
		\Stripe\Stripe::setApiKey('censored');
		$customer = \Stripe\Customer::create([
			'name' => $name,
			'email' => $array['email-address'],
			'address' => [
				'line1' => $address,
				'city' => $array['city'],
				'state' => $array['province'],
				'country' => $array['country'],
			],
			'source' => $token
		]);
		try {
			\Stripe\Charge::create([
				'customer' => $customer->id,
				'amount' => $amount,
				'currency' => 'cad',
				'description' => 'Donation',
			]);
			$body = "<p>Thank you for your very generous donation.</p>";
		} catch(\Stripe\Exception\CardException $e) {
			// Since it's a decline, \Stripe\Exception\CardException will be caught
			$body = 'Status is:' . $e->getHttpStatus() . '\n';
			$body = $body . 'Type is:' . $e->getError()->type . '\n';
			$body = $body . 'Code is:' . $e->getError()->code . '\n';
			// param is '' in this case
			$body = $body . 'Param is:' . $e->getError()->param . '\n';
			$body = $body . 'Message is:' . $e->getError()->message . '\n';
		} catch (\Stripe\Exception\RateLimitException $e) {
			// Too many requests made to the API too quickly
			$body = "<p>We apologize for any inconvenience, our API is currently overworked.</p>";
		} catch (\Stripe\Exception\InvalidRequestException $e) {
			// Invalid parameters were supplied to Stripe's API
			$body = "<p>Incorrect parameters were submitted to our credit card processor.</p>";
		} catch (\Stripe\Exception\AuthenticationException $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$body = "<p>There was a communication problem between our server and our credit card processor.</p>";
		} catch (\Stripe\Exception\ApiConnectionException $e) {
			// Network communication with Stripe failed
			$body = "<p>There was a communication problem between our server and our credit card processor.</p>";
		} catch (\Stripe\Exception\ApiErrorException $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$body = "<p>There was a problem submitting your donation request.</p>";
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$body = "<p>An unknown problem occurred</p>";
		}
	}
} else {
	ob_start();
	include('main.php');
	$body = ob_get_contents();
	ob_end_clean();
}


?>

<!doctype html>
<html lang="en">
	<head>
		<?php
		if ($server === 'cdunion.ca') {
			include ($root . 'common/google-analytics.php');
		}
		?>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Stripe - The Canadian Disability Union</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap">
		<link rel="stylesheet" href="<?php echo($base); ?>common/css.css?v=1.00">
		<link rel="stylesheet" href="<?php echo($base); ?>common/menu.css?v=1.03">
		<link rel="preload" href="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" as="script">
		<link rel="preload" href="https://s3.amazonaws.com/menumaker/menumaker.min.js" as="script">
		<link rel="preload" href="https://js.stripe.com/v3/" as="script">
		<script async src="https://kit.fontawesome.com/bbe1b77f5f.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="page">
			<header>
				<h1>The Canadian Disability Union</h1>
				<div id="cssmenu">
					<ul>
						<li><a href="<?php echo($base); ?>"><i class="fas fa-home"></i> &nbsp;Home</a></li>
						<li><a href="#"><i class="fas fa-bars"></i> &nbsp;Menu</a>
							<ul>
								<li><a href="<?php echo($base); ?>programs/">Programs</a></li>
								<li><a href="<?php echo($base); ?>disability-facts/">Facts</a></li>
								<li><a href="<?php echo($base); ?>what-percentage-of-adults-are-disabled/">Survey</a></li>
							</ul>
						</li>
						<li><a href="#">Other</a>
							<ul>
								<li><a href="<?php echo($base); ?>news/">News</a></li>
								<li><a href="<?php echo($base); ?>help-wanted/">Help Wanted</a></li>
								<li><a href="<?php echo($base); ?>sponsors/">Sponsors</a></li>
								<li><a href="<?php echo($base); ?>contact-us/">Contact Us</a></li>
								<li><a href="<?php echo($base); ?>about-us/">About Us</a></li>
								<li><a href="<?php echo($base); ?>privacy-policy/">Privacy Policy</a></li>
								<li><a href="<?php echo($base); ?>social-media/">Social Media</a></li>
							</ul>
						</li>
						<li><a href="<?php echo($base); ?>donate/"><i class="fas fa-donate"></i> &nbsp;Please Donate</a></li>
						<li><a href="<?php echo($base); ?>newsletter/">Newsletter Signup</a></li>
					</ul>
				</div>
			</header>
			<main>
				<h2>Credit Card Donation</h2>
				<?php
				echo ($body);
				?>
			</main>
			<footer>
			</footer>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>
		<script src="https://js.stripe.com/v3/"></script>
		<script>
			$("#cssmenu").menumaker({
				title: "Menu",
				breakpoint: 768,
				format: "multitoggle"
			});
		</script>
		<script>
			// Set your publishable key: remember to change this to your live publishable key in production
			// See your keys here: https://dashboard.stripe.com/account/apikeys
			// var stripe = Stripe('censored');
			var stripe = Stripe('censored');
			var elements = stripe.elements();
			// Custom styling can be passed to options when creating an Element.
			var style = {
				base: {
					// Add your base input styles here. For example:
					color: "#32325d",
				}
			};
			// Create an instance of the card Element.
			var card = elements.create('card', {style: style});
			// Add an instance of the card Element into the `card-element` <div>.
			card.mount('#card-element');
			// Create a token or display an error when the form is submitted.
			var form = document.getElementById('payment-form');
			form.addEventListener('submit', function(event) {
				event.preventDefault();
				stripe.createToken(card).then(function(result) {
					if (result.error) {
						// Inform the customer that there was an error.
						var errorElement = document.getElementById('card-errors');
						errorElement.textContent = result.error.message;
					} else {
						function stripeTokenHandler(token) {
							// Insert the token ID into the form so it gets submitted to the server
							var form = document.getElementById('payment-form');
							var hiddenInput = document.createElement('input');
							hiddenInput.setAttribute('type', 'hidden');
							hiddenInput.setAttribute('name', 'stripeToken');
							hiddenInput.setAttribute('value', token.id);
							form.appendChild(hiddenInput);
							// Submit the form
							form.submit();
						}
						// Send the token to your server.
						stripeTokenHandler(result.token);
					}
				});
			});
		</script>
	</body>
</html>
