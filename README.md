# Stripe-Credit-Card-Processing

These files is a generally a working script which connects securely to Stripe to process credit card transactions. I say generally because on appearance, I don't see any problems and I have tested it with no major problems, a few minor things i don't like, but they are more cosmetic than anything. I have not tested this script thoroughly or placed it live yet, use at your own risk, all liability is placed on you if you decide to use it.

In order for the script to work properly you must use your own public and private keys (I censored mine), you must install the stripe library via Composer on both your testing and live server. And you must change the location addresses to match yours, unless your files are in the exact same place as mine, my location will not work and will result in an error.

No credit card number, cvc, expiry date or postal code is transmitted via your server, they are sent directly to Stripe, and your server is sent a token, which you submit to Stripe. The beauty of this is there is no chance of you revealing an individuals' credit card info, and on rare chance the token is intercepted, it's useless to anyone else and contains no credit card information. The best defense against hackers is don't transmit or store any private information, if you have nothing of value, they won't be interested in you.

This script uses paymentcharges and is in compliance with North American security standards and regulations, however, it does not comply with European standards and regulations which are much more strict. I'm not a lawyer, these are nothing more than my belief, please consult with a lawyer before taking my advice, if you fail to consult a lawyer and take my advice which is as is, you accept all liability for anything done wrong.

With that said, my next step is to create a script which uses client secrets, paymentintents and complies with European Standards and regulations. If you would like to assist in that or even improve my current script, please do and add to it, merci.
