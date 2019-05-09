<?php
/**
 * CompletePurchase | src/Message/Response/CompletePurchase.php.
 *
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @package		Omnipay-IngenicoePayments
 * @since       v0.1
 */

namespace Omnipay\IngenicoePayments\Message\Response;

class CompletePurchase extends AbstractResponse
{

	public function rootElementExists(){
        return isset($this->data['orderID']);
    }
    
    public function getTransactionId()
    {
        return $this->data['orderID'];
    }
    
    public function getCurrency()
    {
        return $this->data['currency'];
    }
    
    public function getAmount()
    {
        return floatval($this->data['amount']);
    }
    
    public function getPaymentMethod()
    {
        return $this->data['PM'];
    }
    
    public function getOgoneStatus()
    {
        return $this->data['STATUS'];
    }
    
    public function getStatus()
    {
        switch ($this->getOgoneStatus()) {
            case '1':
                return 'Cancelled by customer';
                break;
            case '4':
                return 'Order stored';
                break;
            case '40':
                return 'Stored waiting external result';
                break;
            case '41':
                return 'Waiting for client payment';
                break;
            case '46':
                return 'Waiting authentication';
                break;
            case '5':
                return 'Authorised';
                break;
            case '50':
                return 'Authorised, waiting external result';
                break;
            case '51':
                return 'Authorised waiting';
                break;
            case '52':
                return 'Authorised not known';
                break;
            case '55':
                return 'Standby';
                break;
            case '56':
                return 'Ok with scheduled payments';
                break;
            case '57':
                return 'Not ok with scheduled payments';
                break;
            case '59':
                return 'Authorization to be requested manually';
                break;
            case '6':
                return 'Authorised and cancelled';
                break;
            case '61':
                return 'Authorised deletion waiting';
                break;
            case '62':
                return 'Authorised deletion uncertain';
                break;
            case '63':
                return 'Authorised deletion refused';
                break;
            case '64':
                return 'Authorised and cancelled';
                break;
            case '7':
                return 'Payment deleted';
                break;
            case '71':
                return 'Payment deletion waiting';
                break;
            case '72':
                return 'Payment deletion uncertain';
                break;
            case '73':
                return 'Payment deletion refused';
                break;
            case '74':
                return 'Payment deleted';
                break;
            case '8':
                return 'Refund';
                break;
            case '81':
                return 'Refund pending';
                break;
            case '82':
                return 'Refund uncertain';
                break;
            case '83':
                return 'Refund refused';
                break;
            case '84':
                return 'Refund';
                break;
            case '85':
                return 'Refund handled by merchant';
                break;
            case '9':
                return 'Payment requested';
                break;
            case '91':
                return 'Payment processing';
                break;
            case '92':
                return 'Payment uncertain';
                break;
            case '93':
                return 'Payment refused';
                break;
            case '94':
                return 'Payment declined by the acquirer';
                break;
            case '95':
                return 'Payment handled by merchant';
                break;
            case '96':
                return 'Payment reversed';
                break;
            case '99':
                return 'Being processed';
                break;
        }
    }
    
    public function getCardNumber()
    {
        return $this->data['CARDNO'];
    }

    public function getExpirationDate()
    {
        return $this->data['ED'];
    }

    public function getCardholderName()
    {
        return $this->data['CN'];
    }

    public function getTransactionDate()
    {
        return $this->data['TRXDATE'];
    }
    
    public function getTransactionReference()
    {
        return $this->data['PAYID'];
    }

    public function getBrand()
    {
        return $this->data['BRAND'];
    }

    public function getIp()
    {
        return $this->data['IP'];
    }

    public function getShaSignature()
    {
        return $this->data['SHASIGN'];
    }
   
}