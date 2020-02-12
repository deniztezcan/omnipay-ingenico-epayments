# Omnipay: Ingenico ePayments

**Ingenico ePayments driver (e-Commerce) for the Omnipay PHP payment processing library**

[![Latest Stable Version](https://poser.pugx.org/deniztezcan/omnipay-ingenico-epayments/v/stable)](https://packagist.org/packages/deniztezcan/omnipay-ingenico-epayments) 
[![Total Downloads](https://poser.pugx.org/deniztezcan/omnipay-ingenico-epayments/downloads)](https://packagist.org/packages/deniztezcan/omnipay-ingenico-epayments) 
[![Latest Unstable Version](https://poser.pugx.org/deniztezcan/omnipay-ingenico-epayments/v/unstable)](https://packagist.org/packages/deniztezcan/omnipay-ingenico-epayments) 
[![License](https://poser.pugx.org/deniztezcan/omnipay-ingenico-epayments/license)](https://packagist.org/packages/deniztezcan/omnipay-ingenico-epayments)

[Omnipay 3.x](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment processing library for PHP 5.6+

Table of Contents
=================
* [Installation](#installation)
* [Payment](#Do&#32;a&#32;Payment)
* [Complete Payment](#Complete&#32;a&#32;Payment)
* [Support](#support)

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/).

```
composer require deniztezcan/omnipay-ingenico-epayments:^1
```

## Do a Payment

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('IngenicoePayments');

$gateway->setMode('test');
$gateway->setPSPID('PSID');
$gateway->setLanguage('nl_NL');
$gateway->setShaIn('SHAIN');
$gateway->setShaOut('SHAOUT');
$gateway->setHashing('SHA-1');

$request = $gateway->purchase([
	'amount' => 9999, 
	'currency' => 'EUR', 
	'returnUrl' => 'https://example.com/tmp/done',
	'cancelUrl' => 'https://example.com/tmp/cancel', 
	'transactionId' => '1111111', 
	'description' => 'DESCRIPTION',
	'paymentMethod' => 'PAYMENTMETHOD',
	'card'	=> [
		'firstName'			=> 'firstName',
		'lastName'			=> 'lastName',
		'billingAddress1'	=> 'billingAddress1',
		'postcode'			=> 'postcode',
		'city'				=> 'city',
		'phone'				=> 'phone',
		'email'				=> 'email'
	],
	'customfields' => [
		'XX' => 'XX',
	]
]);
$response = $request->send();
$response->redirect();
```

You will be transfered to the e-Commerce page of Ingenico.

## Complete a Payment

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('IngenicoePayments');

$gateway->setMode('test');
$gateway->setPSPID('PSID');
$gateway->setLanguage('nl_NL');
$gateway->setShaIn('SHAIN');
$gateway->setShaOut('SHAOUT');

$request = $gateway->completePurchase(['transaction' => $_GET]);
$response = $request->send();

if ($response->isSuccessful()) {
	echo $response->getTransactionId();
}else{
	echo $response->getError();
}
```

## Support

If you are having general issues with Omnipay, we suggest posting on [Stack Overflow](http://stackoverflow.com/). Be sure to add the [omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/deniztezcan/omnipay-ingenico-epayments/issues), or better yet, fork the library and submit a pull request.