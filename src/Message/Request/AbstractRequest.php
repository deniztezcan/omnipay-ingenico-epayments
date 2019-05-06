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

   public function getPaymentURL()
    {
        return $this->getParameter('paymentURL');
    }

    public function setPaymentURL($value)
    {
        return $this->setParameter('paymentURL', $value);
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

    public function getHomeUrl()
    {
        return $this->getParameter('homeURL');
    }

    public function setHomeUrl($value)
    {
        return $this->setParameter('homeURL', $value);
    }

    public function getOrderID()
    {
        return $this->getParameter('order_id');
    }

    public function setOrderID($value)
    {
        return $this->setParameter('order_id', $value);
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

    public function getSignature($xml)
    {
        $signature = "";
        $signature.= 'ACCEPTURL=' . $this->getReturnUrl() . $this->getShaIn();
        $signature.= 'AMOUNT=' . number_format($this->getAmount()*100, 0, '', '') . $this->getShaIn();
        $signature.= 'BACKURL=' . $this->getCancelUrl() . $this->getShaIn();
        if($this->getBrand() != ""){
            $signature.= 'BRAND=' .  . $this->getShaIn();
        }
        $signature.= 'CANCELURL=' . $this->getCancelUrl() . $this->getShaIn();
        $signature.= 'CATALOGURL=' . $this->getHomeUrl() . $this->getShaIn();
        $signature.= 'CN=' . $this->getCard()->getFirstName() . " " . $this->getCard()->getLastName() . $this->getShaIn();
        $signature.= 'COM=' . $this->getDescription() . $this->getShaIn();
        $signature.= 'CURRENCY=' . $this->getCurrency() . $this->getShaIn();
        $signature.= 'DECLINEURL=' . $this->getCancelUrl() . $this->getShaIn();
        $signature.= 'EMAIL=' . $this->getCard()-> . $this->getShaIn();
        $signature.= 'EXCEPTIONURL=' . $this->getCancelUrl() . $this->getShaIn();
        $signature.= 'HOMEURL=' . $this->getHomeUrl() . $this->getShaIn();
        $signature.= 'LANGUAGE=' . $this->getLanguage() . $this->getShaIn();
        $signature.= 'ORDERID=' . $this->getOrderID() . $this->getShaIn();
        $signature.= 'OWNERADDRESS=' . $this->getCard()->getBillingAddress1() . $this->getShaIn();
        $signature.= 'OWNERTELNO=' . $this->getCard()->getBillingPhone() . $this->getShaIn();
        $signature.= 'OWNERTOWN=' . $this->getCard()->getBillingCity() . $this->getShaIn();
        $signature.= 'OWNERZIP=' . $this->getCard()->getBillingPostcode() . $this->getShaIn();
        $signature.= 'PM=' . $this->getPaymentMethod() . $this->getShaIn();
        $signature.= 'PSPID=' . $this->getPSPID() . $this->getShaIn();
        return sha1($signature);
    }
    

    public function getBaseData($type, $name, $config)
    {
        $this->validate('acquirer', 'testMode', 'merchantId', 'subId', 'privateCerPath', 'privateKeyPath', 'privateKeyPassphrase');
        
        return $data;
    }
    
    public function sendData($data)
    {  
        $response = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            [
                'Content-Type' => 'application/json'
            ],
            $data
        );

        var_dump($response);exit;

        return $this->createResponse($response->getBody()->getContents());
    }

    abstract public function createResponse($payload);

    public function getEndpoint()
    {
        return "https://secure.ogone.com/ncol/" . $this->getMode() . "/orderstandard.asp";
    }

}