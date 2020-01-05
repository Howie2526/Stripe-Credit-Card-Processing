<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

unset($body);

if ((!isset($_POST['form-title'])) || (!isset($_POST['middle-name'])) || (!isset($_POST["first-name"])) || (!isset($_POST["last-name"])) || (!isset($_POST["donation-amount"])) || (!isset($_POST["email-address"])) || (!isset($_POST["unit"])) || (!isset($_POST["address"])) || (!isset($_POST["city"])) || (!isset($_POST["province"])) || (!isset($_POST["country"])) || (!isset($_POST["stripeToken"]))) {
	$body = include($root . 'credit-card-donation/form.php');
}

if (!isset($body)) {
	$form_title = ($_POST['form-title']);
	$middle_name = ($_POST['middle-name']);
	$first_name = ($_POST["first-name"]);
	$last_name = ($_POST["last-name"]);
	$donation_amount = ($_POST["donation-amount"]) . '00';
	$email_address = ($_POST["email-address"]);
	$unit = ($_POST["unit"]);
	$address = ($_POST["address"]);
	$city = ($_POST["city"]);
	$province = ($_POST["province"]);
	$country = ($_POST["country"]);
	$token = ($_POST["stripeToken"]);
	if (empty($first_name) || empty($last_name) || empty($address) || empty($city) || empty($province) || empty($country)) {
		$body = "<p>You did not fill out all required fields.</p>";
	}
	if ($form_title != 'Credit Card Donation') {
		$body = $body . "<p>Form Title is not considered valid.</p>";
	}
	if (!empty($middle_name)) {
		$body = $body . "<p>Middle Name is not considered valid.</p>";
	}
	if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
		$body = $body . "<p>Email Address is not considered valid.</p>";
	}
	if (isset($body)) {
		$body = $body . "<p>Please enable javascript and return to our Donation Page.</p>";
	}
}

if (!isset($body)) {
	$full_name = $first_name . " " . $last_name;
	if (empty($unit)) {
		$full_address = $address;
	} else {
		$full_address = $unit . "-" . $address;
	}
	require_once 'C:/xampp/composer/vendor/autoload.php';
	\Stripe\Stripe::setApiKey('censored');
	$customer = \Stripe\Customer::create([
		'name' => $full_name,
		'email' => $email_address,
		'address' => [
			'line1' => $full_address,
			'city' => $city,
			'state' => $province,
			'country' => $country,
		],
		'source' => $token,
	]);
	try {
		\Stripe\Charge::create([
			'customer' => $customer->id,
			'amount' => $donation_amount,
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

echo ($body);

?>
