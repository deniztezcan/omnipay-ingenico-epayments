<?php
/**
 * Purchase | src/Message/Response/Purchase.php.
 *
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @package		Omnipay-IngenicoePayments
 * @since       v0.1
 */

namespace Omnipay\IngenicoePayments\Message\Response;

class Purchase extends AbstractResponse
{

	public function rootElementExists(){
        return true;
    }

    public function isSuccessful(){
        return true;
    }

    public function redirect(){
        echo $this->data;
    }
   
}