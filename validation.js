function ValidateName(){
	var Name=document.getElementById('name');
	var NameError=document.getElementById('name-error');
	if(Name.value==''){
		event.preventDefault();
		NameError.style.display='block';
		NameError.innerHTML='Name is required';
	}else if(Name.value.length>64){
		event.preventDefault;
		NameError.style.display='block';
		NameError.innerHTML='Name cannot be more than 64 characters';
	}else{
		NameError.style.display='none';
	}
}

function ValidateEmailAddress(){
	var EmailAddress=document.getElementById('email-address');
	var EmailAddressError=document.getElementById('email-address-error');
	var EmailAddressPattern=/\S+@\S+\.\S+/;
	if(EmailAddress.value==''){
		event.preventDefault();
		EmailAddressError.style.display='block';
		EmailAddressError.innerHTML='Email Address is required';
	}else if(!EmailAddress.value.match(EmailAddressPattern)){
		event.preventDefault();
		EmailAddressError.style.display='block';
		EmailAddressError.innerHTML='Email Address is not in the correct format';
	}else if(EmailAddress.value.length>64){
		event.preventDefault();
		EmailAddressError.style.display='block';
		EmailAddressError.innerHTML='Email Address has a maximum 64 character limit';
	}else{
		EmailAddressError.style.display='none';
	}
}

function ValidateDonation(){
	var Donation=document.getElementById('donation');
	var DonationError=document.getElementById('donation-error');
	var DonationPattern=/\D/;
	if(Donation.value==''){
		event.preventDefault();
		DonationError.style.display='block';
		DonationError.innerHTML='Donation is required';
	}else if(Donation.value.match(/[.]/)){
		event.preventDefault();
		DonationError.style.display='block';
		DonationError.innerHTML='Only dollars, no cents';
	}else if(Donation.value.match(DonationPattern)){
		event.preventDefault();
		DonationError.style.display='block';
		DonationError.innerHTML='Donation contains invalid characters';
	}else if(Donation.value<5){
		event.preventDefault();
		DonationError.style.display='block';
		DonationError.innerHTML='There is a minimum donation of $5';
	}else if(Donation.value>1000){
		event.preventDefault();
		DonationError.style.display='block';
		DonationError.innerHTML='There is a maximum donation of $1000';
	}else{
		DonationError.style.display='none';
	}
}
