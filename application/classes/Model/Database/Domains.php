<?php
/**
 * Model_Database_Domains
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-09-01		Artem Kolombet		[1.0]					created
 */
class Model_Database_Domains extends Model_System_ApplicationModelDatabase
{
	private $oConfig = null;
	private $oDbConfig = null;
	private $iIpAddressId = 0;
		
	function __construct(Kohana_Request $oRequest = null)
	{
		parent::__construct($oRequest);
		
		$this->oConfig = (object) Kohana::$config->load('sell_domains');
		$this->oDbConfig = Kohana::$config->load('database');
	}
	
	public function selectDomain($iDomainId = 0, $sName = '')
	{
		if($iDomainId <= 0 && empty($sName))
			return null;
		
		ob_start();?>
			SELECT 
				sdo_id,
				sdo_name,
				sdo_hosting,
				sdo_active,
				sdo_created_datetime,
				sdo_ipv4_id,
				sdo_modified_datetime,
				sdo_modified_ipv4_id,
				sdo_deleted,
				sdo_deleted_datetime,
				sdo_deleted_ipv4_id
				
			FROM <?=$this->oDbConfig['default']['table_prefix'].$this->oConfig['db']['domains']?>
			
			WHERE 
			<?php if($iDomainId > 0) {?>
				sdo_id = :sdo_id
			<?php } ?>
			
			<?php if($iDomainId > 0 && !empty($sName)) { ?>
				AND
			<?php } ?>
			
			<?php if(!empty($sName)) { ?>
				sdo_name = :sdo_name
			<?php } ?>		
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::SELECT, $sQuery);
		
		$aParameters = array();
		
		if($iDomainId > 0)
			$aParameters[':sdo_id'] = $iDomainId;
		
		if(!empty($sName))
			$aParameters[':sdo_name'] = $sName;
			
		return $oQuery->parameters($aParameters)->as_object()->execute()->current();
	}
	
	public function selectPrice($iDomainId)
	{
		ob_start();?>
		
		SELECT
			sdo_id,
			sdp_type,
			sdp_value,
			sdp_created_datetime,
			sdp_modified_datetime,
			sdp_ipv4_id,
			sdp_modified_ipv4_id
			
		FROM <?=$this->oDbConfig['default']['table_prefix'].$this->oConfig['db']['price']?>
		
		WHERE 
			sdo_id = :sdo_id
		
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::SELECT, $sQuery);
		
		return $oQuery->param(':sdo_id', $iDomainId)->as_object()->execute()->as_array();
	}
	
	public function insertPrice($iDomainId, $sPriceType, $sPrice)
	{	
		$iIpv4Id = $this->getIpAddressId(Request::$client_ip);
		
		ob_start();?>
		
		INSERT INTO <?=$this->oDbConfig['default']['table_prefix'].$this->oConfig['db']['price']?>
	    (sdo_id,
	     sdp_type,
	     sdp_value,
			 sdp_ipv4_id
			 )
			 
		VALUES (
			:sdo_id,
			:sdp_type,
			:sdp_value,
			:sdp_ipv4_id	
		)	
		
		ON DUPLICATE KEY UPDATE
			sdo_id = LAST_INSERT_ID(sdo_id),
			sdp_value = :sdp_value2,
			sdp_modified_ipv4_id = :sdp_modified_ipv4_id,
			sdp_modified_datetime = :sdp_modified_datetime
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::INSERT, $sQuery);
		
		$oQuery->parameters(array(
	    ':sdo_id' => $iDomainId,
	    ':sdp_type' => $sPriceType,
	    ':sdp_value' => $sPrice,
	    ':sdp_value2' => $sPrice,
	    ':sdp_ipv4_id' => $iIpv4Id,
	    ':sdp_modified_ipv4_id' => $iIpv4Id,
	    ':sdp_modified_datetime' => date('Y-m-d H:i:s')
		));

		return $oQuery->execute(); 	
	}
	
	public function insertDomain($sName, $bActive = true, $bHosting = false)
	{	
		ob_start(); ?>
		
		INSERT INTO <?=$this->oDbConfig['default']['table_prefix'].$this->oConfig['db']['domains']?>
	    (sdo_name,
	     sdo_hosting,
	     sdo_active,
			 sdo_ipv4_id
			 )
			 
		VALUES (
			:sdo_name,
			:sdo_hosting,
			:sdo_active,
			:sdo_ipv4_id
		)	
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::INSERT, $sQuery);
		
		$oQuery->parameters(array(
	    ':sdo_name' => $sName,
	    ':sdo_hosting' => intval($bHosting),
	    ':sdo_active' => intval($bActive),
	    ':sdo_ipv4_id' => $this->getIpAddressId(Request::$client_ip) 
		));
			
		$aDomain = $oQuery->execute();
		
		return $aDomain[0] > 0 ? $aDomain[0] : false;
	}
	
	public function updateDomain($iDomainId = 0,  $sName = '', $bActive = true, $bHosting = false)
	{
		if($iDomainId <= 0 && empty($sName))
			return null;
		
		ob_start(); ?>
		
		UPDATE <?=$this->oDbConfig['default']['table_prefix'].$this->oConfig['db']['domains']?>
		
		SET
			sdo_active = :sdo_active,
			sdo_hosting = :sdo_hosting,
			sdo_modified_ipv4_id = :sdo_modified_ipv4_id,
			sdo_modified_datetime = :sdo_modified_datetime
		
		WHERE 
			<?php if($iDomainId > 0) {?>
				sdo_id = :sdo_id
			<?php } ?>
			
			<?php if($iDomainId > 0 && !empty($sName)) { ?>
				AND
			<?php } ?>
			
			<?php if(!empty($sName)) { ?>
				sdo_name = :sdo_name
			<?php } ?>		
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::UPDATE, $sQuery);
		
		$aParameters = array(
	    ':sdo_hosting' => intval($bHosting),
	    ':sdo_active' => intval($bActive),
	    ':sdo_modified_ipv4_id' => $this->getIpAddressId(Request::$client_ip),
			':sdo_modified_datetime' => date('Y-m-d H:i:s')
		);
		
		if($iDomainId > 0)
			$aParameters[':sdo_id'] = $iDomainId;
		
		if(!empty($sName))
			$aParameters[':sdo_name'] = $sName;
		
		$oQuery->parameters($aParameters);

		$aDomain = $oQuery->execute();

		return $aDomain[0] > 0 ? $aDomain[0] : false;	
	}
	
	public function insertArchive($iDomainId, $sPriceType, $sPrice = '', $sPriceAddedDatetime = '', $sPriceAddedIpv4 = '')
	{	
		ob_start();?>
		
		INSERT INTO <?=$this->oDbConfig['default']['table_prefix'].$this->oConfig['db']['archive']?>
		(
			sdo_id,
			sda_price_type,
			sda_price,
			sda_sdp_datetime,
			sda_sdp_ipv4_id,
			sda_ipv4_id
		)
		VALUES
		(
			:sdo_id,
			:sda_price_type,
			:sda_price,
			:sda_sdp_datetime,
			:sda_sdp_ipv4_id,
			:sda_ipv4_id
		)
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::INSERT, $sQuery);
		
		$oQuery->parameters(array(
	    ':sdo_id' => $iDomainId,
	    ':sda_price_type' => $sPriceType,
	    ':sda_price' => $sPrice,
	    ':sda_sdp_datetime' => $sPriceAddedDatetime,
	    ':sda_sdp_ipv4_id' => $sPriceAddedIpv4,
	    ':sda_ipv4_id' => $this->getIpAddressId(Request::$client_ip)
		));
			
		$aArchive = $oQuery->execute();
		
		return $aArchive[0] > 0 ? $aArchive[0] : false;
	}
	
	/**
	 * Model_Database_Domains::selectDomains()
	 * 
	 * @param integer $bHosting. -1 - select all, 0 - selece domains only, 1 - select hostings only. default -1
	 * @param bool $bActiveOnly. true - select active only, false - select all. default true 
	 * @param bool $bIncludeDeleted. true - include deleted in the result. false - return only not deleted. default false
	 * @return void
	 */
	public function selectDomains($bHosting = -1, $bActiveOnly = true, $bIncludeDeleted = false)
	{
		ob_start();?>
		
		SELECT
			sdo_id,
		  sdo_name,
		  sdo_hosting,
		  sdo_active,
		  sdo_created_datetime,
		  sdo_ipv4_id,
		  sdo_modified_datetime,
		  sdo_modified_ipv4_id,
		  sdo_deleted,
		  sdo_deleted_datetime,
		  sdo_deleted_ipv4_id
	  
		FROM  <?=$this->oDbConfig['default']['table_prefix'].$this->oConfig['db']['domains']?>
		
		WHERE	
			sdo_id > 0
			
		<?php if($bActiveOnly) { ?>
			AND sdo_active = 1
		<?php }
			
		if($bHosting >= 0) { ?>
			AND sdo_hosting = :sdo_hosting
		<?php }
		
		if(!$bIncludeDeleted) { ?>
			AND (sdo_deleted IS NULL OR sdo_deleted = '' OR sdo_deleted = 0)
		<?php } ?>

		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::SELECT, $sQuery);
		
		$aParam = array();
		
		if($bHosting >= 0)
			$aParam[':sdo_hosting'] = intval($bHosting);
		
		$oQuery->parameters($aParam);
			
		return $oQuery->as_object()->execute()->as_array();
	}
	
	private function deleteDomain($iDomainId = null, $sName = '')
	{
		
	}
	
	private function deleteArchive()
	{
		
	}
	
	private function getIpAddressId($sIpAddress = '')
	{
		if($this->iIpAddressId <= 0)
		{
			$oModelIpAddr = new Model_Ipaddress;
			$this->iIpAddressId = $oModelIpAddr->getIpAddressId(empty($sIpAddress) ? Request::$client_ip : $sIpAddress);	
		}
		
		return $this->iIpAddressId;
	}
	
	public function findDomainByLike($sAttribute, $sLike = '')
	{
		ob_start();?>
		SELECT
		  sdo_id,
		  sdo_name,
		  sdo_hosting,
		  sdo_active,
		  sdo_deleted
		FROM akb_sell_domain
		WHERE sdo_active = 1
		    AND (sdo_deleted IS NULL
		          OR sdo_deleted = ''
		          OR sdo_deleted = '0')
		          
		    AND <?=$sAttribute?> LIKE :sdo_like      
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::SELECT, $sQuery);
		
		$oQuery->param(':sdo_like', '%'.$sLike.'%');
			
		return $oQuery->as_object()->execute()->as_array();
	}
}