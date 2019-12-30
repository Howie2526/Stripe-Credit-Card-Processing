<!doctype html>
<html lang="en">
	<head>
		<?php
		if ($server === 'cdunion.ca') {
			include ($root . '/google-analytics.php');
		}
		?>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Stripe - The Canadian Disability Union</title>
		<meta name="robots" content="noindex, nofollow">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap">
		<link rel="stylesheet" href="<?php echo($base); ?>styles.css?v=1.10">
		<link rel="stylesheet" href="<?php echo($base); ?>menu.css?v=1.02">
		<link rel="preload" href="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" as="script">
		<link rel="preload" href="https://s3.amazonaws.com/menumaker/menumaker.min.js" as="script">
		<script async src="https://kit.fontawesome.com/bbe1b77f5f.js" crossorigin="anonymous"></script>
		<script src="https://js.stripe.com/v3/"></script>
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
				<h2>Stripe</h2>
				<p>Please note, this page is currently in design stage and not yet meant for public viewing. This page is linked no where else on our site which means if you are viewing it, you came across it by accident or we personally gave you the address. Please do not enter any credit card information as this page is not yet fully secure and complete. If you chose to ignore our advice, it is currently set up for testing meaning even if you do enter any credit card information, no charges will be issued to your credit card.</p>
				<form action="http://localhost/cdunion/stripe/stripe.php" method="post" id="payment-form" style="max-width:600px;">
					<input class="form-title" name="form-title" value="Credit Card Donation">
					<input class="middle-name" id="middle-name" name="middle-name" placeholder="Middle Name" type="text">
					<div class="form-row">
						<div style="display:inline-block;width:100%;">
							<div class="width-50">
								<label for="first-name">First Name &nbsp;<i class="fas fa-asterisk"></i></label><br>
								<input class="input" id="first-name" name="first-name" maxlength="32" placeholder="First Name" type="text" value="Harold" required>
							</div>
							<div class="width-50">
								<label for="last-name">Last Name &nbsp;<i class="fas fa-asterisk"></i></label><br>
								<input class="input" id="last-name" maxlength="32" name="last-name" placeholder="Last Name" type="text" value="Indoe" required>
							</div>
						</div>
						<div>
							<label for="card-element">Credit/Debit Card &nbsp;<i class="fas fa-asterisk"></i></label>
							<div class="input" id="card-element">
							</div>
							<div id="card-errors" role="alert">
							</div>
						</div>
						<div style="display:inline-block;width:100%;">
							<div class="width-50">
								<label for="donation-amount">Donation Amount &nbsp;<i class="fas fa-asterisk"></i></label><br>
								<input class="input" id="donation-amount" name="donation-amount" pattern="(([1-9][0-9][0-9])|([1-9][0-9])|([5-9]))" placeholder="5" title="Min 5, max 999, no cents please." type="text" value="10" required>
							</div>
							<div class="width-50">
								<label for="email-address">Email Address &nbsp;<i class="fas fa-asterisk"></i></label><br>
								<input class="input" id="email-address" name="email-address" placeholder="Email Address" type="email" value="Mankind014@gmail.com" required>
							</div>
						</div>
						<div style="display:inline-block;width:100%;">
							<div class="width-25">
								<label for="unit">Unit #</label><br>
								<input class="input" id="unit" maxlength="10" name="unit" placeholder="Unit #" type="text" value="13">
							</div>
							<div class="width-75">
								<label for="address">Address &nbsp;<i class="fas fa-asterisk"></i></label><br>
								<input class="input" id="address" name="address" placeholder="Address" type="text" value="199 Westwood Rd" required>
							</div>
						</div>
						<div style="display:inline-block;width:100%;">
							<div class="width-35">
								<label for="city">City &nbsp;<i class="fas fa-asterisk"></i></label><br>
								<input class="input" id="city" name="city" placeholder="City" type="text" value="Guelph" required>
							</div>
							<div class="width-35">
								<label for="province-territory">Province/Territory &nbsp;<i class="fas fa-asterisk"></i></label><br>
								<input class="input" id="province-territory" name="province-territory" placeholder="Province/Territory" type="text" value="Ontario" required>
							</div>
							<div class="width-30">
								<label for="country">Country &nbsp;<i class="fas fa-asterisk"></i></label><br>
								<input class="input" id="country" name="country" placeholder="Country" type="text" value="Canada" required>
							</div>
						</div>
						<p></p>
						<div class="center">
							<button class="form-button">Donate</button>
						</div>
					</div>
				</form>
				<p></p>
			</main>
			<footer>
				<div class="footer">
				</div>
			</footer>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>
		<script>
			$("#cssmenu").menumaker({
				title: "Menu",
				breakpoint: 768,
				format: "multitoggle"
			});
		</script>
		</script>
		<script>
			// Create a Stripe client.
			var stripe = Stripe('censored');
			
			// Create an instance of Elements.
			var elements = stripe.elements();
			
			// Custom styling can be passed to options when creating an Element.
			// (Note that this demo uses a wider set of styles than the guide below.)
			var style = {
				base: {
					color: '#32325d',
					fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
					fontSmoothing: 'antialiased',
					fontSize: '16px',
					'::placeholder': {
						color: '#aab7c4'
					}
				},
				invalid: {
					color: '#fa755a',
					iconColor: '#fa755a'
				}
			};
			
			// Create an instance of the card Element.
			var card = elements.create('card', {style: style});
			
			// Add an instance of the card Element into the `card-element` <div>.
			card.mount('#card-element');
			
			// Handle real-time validation errors from the card Element.
			card.addEventListener('change', function(event) {
				var displayError = document.getElementById('card-errors');
				if (event.error) {
					displayError.textContent = event.error.message;
				} else {
					displayError.textContent = '';
				}
			});
			
			// Handle form submission.
			var form = document.getElementById('payment-form');
			form.addEventListener('submit', function(event) {
				event.preventDefault();
				
				stripe.createToken(card).then(function(result) {
					if (result.error) {
						// Inform the user if there was an error.
						var errorElement = document.getElementById('card-errors');
						errorElement.textContent = result.error.message;
					} else {
						// Send the token to your server.
						stripeTokenHandler(result.token);
					}
				});
			});
			
			// Submit the form with the token ID.
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
		</script>
	</body>
</html>
