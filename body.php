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
		<link rel="stylesheet" href="<?php echo($base); ?>common/css.css">
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
				<h2>Donation Via Credit Card</h2>
				<?php
				include ($root . 'credit-card-donation/php.php');
				?>
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
		<script>
			// Set your publishable key: remember to change this to your live publishable key in production
			// See your keys here: https://dashboard.stripe.com/account/apikeys
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
