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
class Model_Database_Ipaddress extends Model_System_ApplicationModelDatabase
{
	function __construct(Kohana_Request $oRequest = null)
	{
		parent::__construct($oRequest);
		
		$this->oDbConfig = Kohana::$config->load('database');
		$this->sTable = $this->oDbConfig['default']['table_prefix'].'ip_address';
	}
	
	public function selectIpAddress($sIpAddress = '')
	{
		$oIpAddress = new Model_Ipaddress(null, false);
		
		if(!$oIpAddress->isIpv4($sIpAddress))
			return null;
			
		ob_start();?>
		
		SELECT 
			ia_id,
			ia_ip_value
			
		FROM <?=$this->sTable?>
		
		WHERE ia_ip_value = INET_ATON(:ia_ip_value)	
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::SELECT, $sQuery);
		
		$oQuery->param(':ia_ip_value', $sIpAddress);
		
		return $oQuery->as_object()->execute()->current();
	}
	
	public function insertIpAddress($sIpAddress = '')
	{
		$oIpAddress = new Model_Ipaddress(null, false);
		
		if(!$oIpAddress->isIpv4($sIpAddress))
			return false;
		
		
		ob_start();?>
		
		INSERT INTO <?=$this->sTable?>
		
		(ia_ip_value)
		
		VALUES (INET_ATON(:ia_ip_value))
		
		ON DUPLICATE KEY UPDATE
			ia_ip_value = INET_ATON(:ia_ip_value2)
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::INSERT, $sQuery);
		
		$oQuery->parameters(array(
	    ':ia_ip_value' => $sIpAddress,
	    ':ia_ip_value2' => $sIpAddress
		));
		
		$oAddr = $oQuery->execute();
		
		return (is_array($oAddr) && count($oAddr) > 0) ? $oAddr[0] : null;
	}
	
	
}