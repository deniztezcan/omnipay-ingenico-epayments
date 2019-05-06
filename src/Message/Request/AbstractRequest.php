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

    public function getSignature()
    {
        $signature = "";
        $signature.= 'ACCEPTURL=' . $this->getReturnUrl() . $this->getShaIn();
        $signature.= 'AMOUNT=' . number_format($this->getAmount()*100, 0, '', '') . $this->getShaIn();
        $signature.= 'BACKURL=' . $this->getCancelUrl() . $this->getShaIn();
        if($this->getBrand() != ""){
            $signature.= 'BRAND=' . $this->getBrand() . $this->getShaIn();
        }
        $signature.= 'CANCELURL=' . $this->getCancelUrl() . $this->getShaIn();
        $signature.= 'CATALOGURL=' . $this->getReturnUrl() . $this->getShaIn();
        $signature.= 'CN=' . $this->getCard()->getFirstName() . ' ' . $this->getCard()->getLastName() . $this->getShaIn();
        $signature.= 'COM=' . $this->getDescription() . $this->getShaIn();
        $signature.= 'CURRENCY=' . $this->getCurrency() . $this->getShaIn();
        $signature.= 'DECLINEURL=' . $this->getCancelUrl() . $this->getShaIn();
        $signature.= 'EMAIL=' . $this->getCard()->getEmail() . $this->getShaIn();
        $signature.= 'EXCEPTIONURL=' . $this->getCancelUrl() . $this->getShaIn();
        $signature.= 'HOMEURL=' . $this->getReturnUrl() . $this->getShaIn();
        $signature.= 'LANGUAGE=' . $this->getLanguage() . $this->getShaIn();
        $signature.= 'ORDERID=' . $this->getTransactionId() . $this->getShaIn();
        $signature.= 'OWNERADDRESS=' . $this->getCard()->getBillingAddress1() . $this->getShaIn();
        $signature.= 'OWNERTELNO=' . $this->getCard()->getBillingPhone() . $this->getShaIn();
        $signature.= 'OWNERTOWN=' . $this->getCard()->getBillingCity() . $this->getShaIn();
        $signature.= 'OWNERZIP=' . $this->getCard()->getBillingPostcode() . $this->getShaIn();
        $signature.= 'PM=' . $this->getPaymentMethod() . $this->getShaIn();
        $signature.= 'PSPID=' . $this->getPSPID() . $this->getShaIn();
        return $signature;
    }
    

    public function getBaseData()
    {

        $form_html = '<form method="post" action="'.$this->getEndpoint().'" id="form1" name="form1">';
        $form_html.= '<input type="hidden" name="PSPID" value="'.$this->getPSPID().'">';
        $form_html.= '<input type="hidden" name="ORDERID" value="'.$this->getTransactionId().'">';
        $form_html.= '<input type="hidden" name="AMOUNT" value="'.number_format($this->getAmount()*100, 0, '', '').'">';
        $form_html.= '<input type="hidden" name="CURRENCY" value="'.$this->getCurrency().'">';
        $form_html.= '<input type="hidden" name="LANGUAGE" value="'.$this->getLanguage().'">';
        $form_html.= '<input type="hidden" name="CN" value="'.$this->getCard()->getFirstName() . ' ' . $this->getCard()->getLastName().'">';
        $form_html.= '<input type="hidden" name="EMAIL" value="'.$this->getCard()->getEmail().'">';
        $form_html.= '<input type="hidden" name="OWNERZIP" value="'.$this->getCard()->getBillingPostcode().'">';
        $form_html.= '<input type="hidden" name="OWNERADDRESS" value="'.$this->getCard()->getBillingAddress1().'">';
        $form_html.= '<input type="hidden" name="OWNERTOWN" value="'.$this->getCard()->getBillingCity().'">';
        $form_html.= '<input type="hidden" name="OWNERTELNO" value="'.$this->getCard()->getBillingPhone().'">';
        $form_html.= '<input type="hidden" name="COM" value="'.$this->getDescription().'">';
        $form_html.= '<input type="hidden" name="SHASIGN" value="'.hash("sha256", $this->getSignature()).'">';
        $form_html.= '<input type="hidden" name="PM" value="'.$this->getPaymentMethod().'">';
        if($this->getBrand() != ""){
            $form_html.= '<input type="hidden" name="BRAND" value="'.$this->getBrand().'">';
        }
        $form_html.= '<input type="hidden" name="ACCEPTURL" value="'.$this->getReturnUrl().'">';
        $form_html.= '<input type="hidden" name="DECLINEURL" value="'.$this->getCancelUrl().'">';
        $form_html.= '<input type="hidden" name="EXCEPTIONURL" value="'.$this->getCancelUrl().'">';
        $form_html.= '<input type="hidden" name="CANCELURL" value="'.$this->getCancelUrl().'">';
        $form_html.= '<input type="hidden" name="BACKURL" value="'.$this->getCancelUrl().'">';
        $form_html.= '<input type="hidden" name="HOMEURL" value="'.$this->getReturnUrl().'">';
        $form_html.= '<input type="hidden" name="CATALOGURL" value="'.$this->getReturnUrl().'">';
        $form_html.= '</form>';

        $form_script = '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>';
        $form_script.= '<script type="text/javascript">';
        $form_script.= '$( document ).ready(function() {';
        $form_script.= '$( "#form1" ).submit();';
        $form_script.= '});';
        $form_script.= '</script>';

        return $form_html.$form_script;
    }
    
    public function sendData($data)
    {  
        echo $data;
        exit;
    }

    abstract public function createResponse($payload);

    public function getEndpoint()
    {
        return "https://secure.ogone.com/ncol/" . $this->getMode() . "/orderstandard.asp";
    }

}