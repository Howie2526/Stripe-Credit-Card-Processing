<form action="<?=$BaseURL;?>credit-card-donation/" method="post" id="payment-form" style="max-width:600px;">
	<input class="hidden" name="form-title" value="Credit Card Donation">
	<input class="hidden" name="middle-name" value="">
	<div class="row">
		<div class="col-sm form-group">
			<label class="form-check-label" for="name">Name &nbsp;<i class="fas fa-asterisk"></i></label>
			<input class="form-control custom-field" id="name" name="name" onkeyup="ValidateName();" placeholder="Name">
			<div class="error form-text hidden" id="name-error"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm form-group">
			<label class="form-check-label" for="email-address">Email Address &nbsp;<i class="fas fa-asterisk"></i></label>
			<input class="form-control custom-field" id="email-address" name="email-address" onkeyup="ValidateEmailAddress();" placeholder="Email Address">
			<div class="error form-text hidden" id="email-address-error"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm form-group">
			<label class="form-check-label" for="donation">Donation &nbsp;<i class="fas fa-asterisk"></i></label>
			<input class="form-control custom-field" id="donation" name="donation" onkeyup="ValidateDonation();" placeholder="Donation">
			<div class="error form-text hidden" id="donation-error"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm form-group">
			<label class="form-check-label" for="card-element">Credit/Debit Card &nbsp;<i class="fas fa-asterisk"></i></label>
			<div class="form-control input custom-field" id="card-element">
			</div>
			<div id="card-errors" role="alert">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm m-4 text-center">
			<button aria-pressed="true" class="btn btn-outline-primary button" onclick="ValidateName();ValidateEmailAddress();ValidateDonation();" style="width:100px;">Donate</button>
		</div>
	</div>
</form>
<p><i class="fas fa-asterisk"></i> Denotes required field</p>
<p>We do not store nor have access to any credit card information. For more information on how we protect your private information, please visit <a href="<?=$BaseURL;?>privacy-policy/#stripe">our privacy policy</a>.</p>
