<?php
/**
 * Model_Database_Ipaddress
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-10-19		Artem Kolombet		[1.0]					created
 */
class Model_Ipaddress extends Model_System_ApplicationModel
{
	public function isIpv4($sIpAddress = '')
	{
		if(!empty($sIpAddress) && !is_null($sIpAddress) && strpos(Request::$client_ip, '::') === false)
			return true;
			
		return false;
	}
	
	public function isIpv6($sIpAddress = '')
	{
		if(!empty($sIpAddress) && !is_null($sIpAddress) && strpos(Request::$client_ip, '::') !== false)
			return true;
			
		return false;
	}
	
	public function getIpAddress($sIpAddress = '')
	{
		return $this->oDbModel->selectIpAddress($sIpAddress);
	}
	
	public function getIpAddressId($sIpAddress = '')
	{
		$oAddr = $this->getIpAddress($sIpAddress);
		
		return (is_object($oAddr) && !empty($oAddr) && isset($oAddr->ia_id)) ? $oAddr->ia_id : $this->addIpAddress($sIpAddress); 
	}
	
	public function addIpAddress($sIpAddress = '')
	{
		return $this->oDbModel->insertIpAddress($sIpAddress);
	}
}