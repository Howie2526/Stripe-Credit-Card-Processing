<form action="<?php echo ($base); ?>credit-card-donation/" method="post" id="payment-form" style="max-width:600px;">
	<input class="form-title" name="form-title" value="Credit Card Donation">
	<input class="middle-name" id="middle-name" name="middle-name" placeholder="Middle Name" type="text">
	<div class="form-row">
		<div style="display:inline-block;width:100%;">
			<div class="width-50">
				<label for="first-name">First Name &nbsp;<i class="fas fa-asterisk"></i></label><br>
				<input class="input" id="first-name" name="first-name" placeholder="First Name" type="text" required>
			</div>
			<div class="width-50">
				<label for="last-name">Last Name &nbsp;<i class="fas fa-asterisk"></i></label><br>
				<input class="input" id="last-name" name="last-name" placeholder="Last Name" type="text" required>
			</div>
		</div>
		<div style="display:inline-block;width:100%;">
			<label for="card-element">Credit/Debit Card &nbsp;<i class="fas fa-asterisk"></i></label><br>
			<div class="input" id="card-element">
			</div><br>
			<div id="card-errors" role="alert">
			</div>
		</div>
		<div style="display:inline-block;width:100%;">
			<div class="width-50">
				<label for="donation-amount">Donation Amount &nbsp;<i class="fas fa-asterisk"></i></label><br>
				<input class="input" id="donation-amount" name="donation-amount" pattern="(1000)||([1-9][0-9][0-9])||([1-9][0-9])||([5-9])" placeholder="Donation Amount" type="text" required>
			</div>
			<div class="width-50">
				<label for="email-address">Email Address &nbsp;<i class="fas fa-asterisk"></i></label><br>
				<input class="input" id="email-address" name="email-address" placeholder="Email Address" type="email" required>
			</div>
		</div>
		<div style="display:inline-block;width:100%;">
			<div class="width-25">
				<label for="unit">Unit</label><br>
				<input class="input" id="unit" name="unit" placeholder="Unit" type="text">
			</div>
			<div class="width-75">
				<label for="address">Address &nbsp;<i class="fas fa-asterisk"></i></label><br>
				<input class="input" id="address" name="address" placeholder="Address" type="text" required>
			</div>
		</div>
		<div style="display:inline-block;width:100%;">
			<div class="width-35">
				<label for="city">City/Rural Route &nbsp;<i class="fas fa-asterisk"></i></label><br>
				<input class="input" id="city" name="city" placeholder="City/Rural Route" type="text" required>
			</div>
			<div class="width-35">
				<label for="province">Province/State &nbsp;<i class="fas fa-asterisk"></i></label><br>
				<input class="input" id="province" name="province" placeholder="Province/State" type="text" required>
			</div>
			<div class="width-30">
				<label for="country">Country &nbsp;<i class="fas fa-asterisk"></i></label><br>
				<input class="input" id="country" name="country" placeholder="Country" type="text" required>
			</div>
		</div>
	</div>
	<div class="center">
		<button class="button">Donate</button>
	</div>
</form>
<p>Please note, we do not store nor have access to any credit card information. For more information on how we protect your private information, please visit <a href="<?php echo ($base); ?>privacy-policy/#stripe">our privacy policy</a>.</p>
