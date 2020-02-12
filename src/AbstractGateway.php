<?php
/**
 * AbstractGateway | src/AbstractGateway.php.
 *
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @package		Omnipay-IngenicoePayments
 * @since       v0.1
 */

namespace Omnipay\IngenicoePayments;

use Omnipay\Common\AbstractGateway as CommonAbstractGateway;

class AbstractGateway extends CommonAbstractGateway{

	public function getName()
    {
    	return 'IngenicoePayments';
    }

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

    public function getHashing()
    {
        return $this->getParameter('hashing');
    }

    public function setHashing($value)
    {
        return $this->setParameter('hashing', $value);
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

}