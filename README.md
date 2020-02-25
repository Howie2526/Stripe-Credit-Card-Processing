# Stripe-Credit-Card-Processing

We have made a few major upgrades to our credit card processing form via Stripe. Our form was already secure and fully compliant with all North American laws, regulations and standards, we have made our form even more secure and are well on our way to meeting European standards which are much more strict.

Upgrades in this version

1. We have integrated Bootstrap into our entire website.
2. We no longer use the Stripe library included in Composer. We now use the PHP library directly from Stripe and available on Stripe's GitHub channel which can be found here, https://github.com/stripe/stripe-php.
3. Our catch errors now work.
4. We have reduced the number of input fields on our form and got rid of some which were not necessary.
5. We now process credit card transactions using paymentintents rather than charges.

Changes were still looking to implement

1. Use the client secret as oppose to a token.
2. Process the entire transaction on the client's computer so neither the token or client secret is sent to our servers.

Please note, this is a fully secure and working credit card procesing form which complies with all North American laws, regulations and standards. This version nor any previous version has ever sent any credit card information to our server. The clients credit card information is encrypted on their computer using a token or client secret, we are sent nothing more than the token or client secret which we than submit to Stripe for processing. This information can only be used once and only by us.

Stripe is a credit card processing company which handles millions of transactions daily. For more information on Stripe please visit https://stripe.com/en-ca.

You are welcome to do with this form as you wish, use it, modify it or assist in improving it. All we ask is if you find this information usefull in your own project, please consider a small donation of $5 to The Canadian Disability Union. We are a legally registered Canadian not-for-profit organization, and more information on us can be found here, https://cdunion.ca/about-us/.

Thank you.
