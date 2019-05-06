<?php
/**
 * Purchase | src/Message/Request/Purchase.php.
 *
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @package		Omnipay-IngenicoePayments
 * @since       v0.1
 */

namespace Omnipay\IngenicoePayments\Message\Request;

use Carbon\Carbon;
use Omnipay\Common\Exception\InvalidRequestException;
use Exception;

class Purchase extends AbstractRequest
{	
	public function getData()
    {
        $data = $this->getBaseData();
        return $data;
    }
    
    public function createResponse($data){
        return new PurchaseResponse($this, $data);
    }
}