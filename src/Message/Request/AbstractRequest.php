<?php
/**
 * AbstractRequest | src/Message/Request/AbstractRequest.php.
 *
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @package		Omnipay-IngenicoePayments
 * @since       v0.1
 */

namespace Omnipay\IngenicoePayments\Message\Request;

use Carbon\Carbon;
use Omnipay\Common\Exception\InvalidRequestException;
use Exception;

use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;

abstract class AbstractRequest extends CommonAbstractRequest
{	

    public function getMode()
    {
        return $this->getParameter('mode');
    }

    public function setMode($value)
    {
        return $this->setParameter('mode', $value);
    }

    public function getPSPID()
    {
        return $this->getParameter('PSPID');
    }

    public function setPSPID($value)
    {
        return $this->setParameter('PSPID', $value);
    }

    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function getShaIn()
    {
        return $this->getParameter('shaIn');
    }

    public function setShaIn($value)
    {
        return $this->setParameter('shaIn', $value);
    }

    public function getShaOut()
    {
        return $this->getParameter('shaOut');
    }

    public function setShaOut($value)
    {
        return $this->setParameter('shaOut', $value);
    }

    public function getBrand()
    {
        return $this->getParameter('brand');
    }

    public function setBrand($value)
    {
        return $this->setParameter('brand', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function getStatus()
    {
        return $this->getParameter('status');
    }

    public function setStatus($value)
    {
        return $this->setParameter('status', $value);
    }

    public function getTransaction()
    {
        return $this->getParameter('transaction');
    }

    public function setTransaction($value)
    {
        return $this->setParameter('transaction', $value);
    }

    public function getCustomfields()
    {
        return $this->getParameter('customfields');
    }

    public function setCustomfields($value)
    {
        return $this->setParameter('customfields', $value);
    }

    public function getSignature()
    {

        $signature = [];
        $signature['ACCEPTURL'] = $this->getReturnUrl() . $this->getShaIn();
        $signature['AMOUNT'] = number_format($this->getAmount(), 0, "", "") . $this->getShaIn();
        $signature['BACKURL'] = $this->getCancelUrl() . $this->getShaIn();
        if($this->getBrand() != ""){
            $signature['BRAND'] = $this->getBrand() . $this->getShaIn();
        }
        $signature['CANCELURL'] = $this->getCancelUrl() . $this->getShaIn();
        $signature['CATALOGURL'] = $this->getReturnUrl() . $this->getShaIn();
        $signature['CN'] = $this->getCard()->getFirstName() . ' ' . $this->getCard()->getLastName() . $this->getShaIn();
        $signature['COM'] = $this->getDescription() . $this->getShaIn();
        $signature['CURRENCY'] = $this->getCurrency() . $this->getShaIn();
        $signature['DECLINEURL'] = $this->getCancelUrl() . $this->getShaIn();
        $signature['EMAIL'] = $this->getCard()->getEmail() . $this->getShaIn();
        $signature['EXCEPTIONURL'] = $this->getCancelUrl() . $this->getShaIn();
        $signature['HOMEURL'] = $this->getReturnUrl() . $this->getShaIn();
        $signature['LANGUAGE'] = $this->getLanguage() . $this->getShaIn();
        $signature['ORDERID'] = $this->getTransactionId() . $this->getShaIn();
        $signature['OWNERADDRESS'] = $this->getCard()->getBillingAddress1() . $this->getShaIn();
        $signature['OWNERTELNO'] = $this->getCard()->getBillingPhone() . $this->getShaIn();
        $signature['OWNERTOWN'] = $this->getCard()->getBillingCity() . $this->getShaIn();
        $signature['OWNERZIP'] = $this->getCard()->getBillingPostcode() . $this->getShaIn();
        $signature['PM'] = $this->getPaymentMethod() . $this->getShaIn();
        $signature['PSPID'] = $this->getPSPID() . $this->getShaIn();

        foreach ($this->getCustomfields() as $key => $value) {
            $signature[$key] = $value . $this->getShaIn();
        }

        ksort($signature);

        return urldecode(http_build_query($signature, '', ''));
    }
    

    public function getBaseData()
    {
        $data = [];
        $data['ACCEPTURL'] = $this->getReturnUrl();
        $data['AMOUNT'] = number_format($this->getAmount(), 0, "", "");
        $data['BACKURL'] = $this->getCancelUrl();
        if($this->getBrand() != ""){
            $data['BRAND'] = $this->getBrand();
        }
        $data['CANCELURL'] = $this->getCancelUrl();
        $data['CATALOGURL'] = $this->getReturnUrl();
        $data['CN'] = $this->getCard()->getFirstName() . ' ' . $this->getCard()->getLastName();
        $data['COM'] = $this->getDescription();
        $data['CURRENCY'] = $this->getCurrency();
        $data['DECLINEURL'] = $this->getCancelUrl();
        $data['EMAIL'] = $this->getCard()->getEmail();
        $data['EXCEPTIONURL'] = $this->getCancelUrl();
        $data['HOMEURL'] = $this->getReturnUrl();
        $data['LANGUAGE'] = $this->getLanguage();
        $data['ORDERID'] = $this->getTransactionId();
        $data['OWNERADDRESS'] = $this->getCard()->getBillingAddress1();
        $data['OWNERTELNO'] = $this->getCard()->getBillingPhone();
        $data['OWNERTOWN'] = $this->getCard()->getBillingCity();
        $data['OWNERZIP'] = $this->getCard()->getBillingPostcode();
        $data['PM'] = $this->getPaymentMethod();
        $data['PSPID'] = $this->getPSPID();
        $data['SHASIGN'] = hash("sha256", $this->getSignature());

        foreach ($this->getCustomfields() as $key => $value) {
            $data[$key] = $value;
        }

        return json_encode($data);
    }
    
    public function sendData($data)
    {  
        if(is_string($data)){
            $response = $this->httpClient->request(
                'POST',
                $this->getEndpoint(),
                [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                http_build_query(json_decode($data, true), '', '&')
            );
            return $this->createResponse($response->getBody()->getContents());
        }else{
            return $this->createResponse($data);
        }
    }

    abstract public function createResponse($payload);

    public function getEndpoint()
    {
        return "https://secure.ogone.com/ncol/" . $this->getMode() . "/orderstandard.asp";
    }

}