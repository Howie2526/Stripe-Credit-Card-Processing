<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$form_title = ($_POST["form-title"]);
$middle_name = ($_POST["middle-name"]);
$first_name = ($_POST["first-name"]);
$last_name = ($_POST["last-name"]);
$donation_amount = ($_POST["donation-amount"]) . '00';
$email_address = ($_POST["email-address"]);
$unit = ($_POST["unit"]);
$address = ($_POST["address"]);
$city = ($_POST["city"]);
$province_territory = ($_POST["province-territory"]);
$country = ($_POST["country"]);

echo ($first_name . "<br>");
echo ($last_name . "<br>");
echo ($donation_amount . "<br>");
echo ($email_address . "<br>");
echo ($unit . "<br>");
echo ($address . "<br>");
echo ($city . "<br>");
echo ($province_territory . "<br>");
echo ($country . "<br>");

if (empty($first_name) || empty($last_name) || empty($address) || empty($city) || empty($province_territory) || empty($country)) {
	echo('You did not fill out all required fields.');
	die();
}
if ($form_title != 'Credit Card Donation') {
	echo('Form Title is not considered valid.');
	die();
}
if (!empty($middle_name)) {
	echo('Middle Name is not considered valid..');
	die();
}
if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
	echo ('Email Address is not considered valid.');
	die();
}

require_once 'C:/xampp/composer/vendor/autoload.php';

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys

\Stripe\Stripe::setApiKey('censored');

// Token is created using Stripe Checkout or Elements!
// Get the payment token ID submitted by the form:


$method = \Stripe\PaymentMethod::create([
	'type' => 'card',
	'card' => [
		'number' => '4242424242424242',
		// 'number' => '4000000000000002', //declined
		'exp_month' => 02,
		'exp_year' => 2020,
		'cvc' => '314',
	],
]);

try {
	\Stripe\PaymentIntent::create([
		'payment_method_types' => ['card'],
		'payment_method' => $method->id,
		'amount' => $donation_amount,
		'currency' => 'cad',
		'confirmation_method' => 'automatic',
		'confirm' => true,
	]);
	$result = 'Thank you for your generous donation.';
} catch (\Stripe\Exception\CardException $e) {
	// Declined
	$result = 'We apologize for the inconvenience but your credit/debit card was declined. Please contact your credit grantor for further information.';
} catch (\Stripe\Exception\RateLimitException $e) {
	// Too many requests made to the API too quickly
	$result = 'We apologize for the inconvenience but our credit card processing API is currently overworked.';
} catch (\Stripe\Exception\InvalidRequestException $e) {
	// Invalid parameters were supplied to Stripe's API
	$result = 'Invalid parameters were submitted to our credit card processing API.';
} catch (\Stripe\Exception\AuthenticationException $e) {
	// Authentication with Stripe's API failed
	// (maybe you changed API keys recently)
	$result = 'We apologize for the inconvenience we are having difficulties communicating with our credit card processor.';
} catch (\Stripe\Exception\ApiConnectionException $e) {
	// Network communication with Stripe failed
	$result = 'We apologize for the inconvenience we are having difficulties communicating with our credit card processor.';
} catch (\Stripe\Exception\ApiErrorException $e) {
	// Display a very generic error to the user, and maybe send
	// yourself an email
	$result = 'There was an error while processing your credit card.';
} catch (Exception $e) {
	// Something else happened, completely unrelated to Stripe
	$result = 'There was an unknown error while processing your credit card.';
}

echo ($result);

die();
?>
