<?php
/**
 * Model_Domains
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
class Model_Domains extends Model_System_ApplicationModel
{
	const PRICE_TYPE_RETAIL = 'retail';
	const PRICE_TYPE_BRONSE = 'bronse';
	const PRICE_TYPE_SILVER = 'silver';
	const PRICE_TYPE_GOLD = 'gold';
	const PRICE_TYPE_PLATINUL = 'platinum'; 
	
	private $aValidationErrors = array();
	
	public function addDomain($sName, $aPrices = array(), $bActive = true, $bHosting = false, $bArchivePrevious = true)
	{
		$oDomain = $this->getDomain($sName, 0, array(self::PRICE_TYPE_RETAIL, self::PRICE_TYPE_BRONSE, self::PRICE_TYPE_SILVER, self::PRICE_TYPE_GOLD, self::PRICE_TYPE_PLATINUL));
	
		if($bArchivePrevious)
		{	
			if(is_object($oDomain) && !empty($oDomain))
				foreach($oDomain->prices as $oPrice)
					$this->oDbModel->insertArchive(
						$oDomain->sdo_id,
						$oPrice->sdp_type,
						$oPrice->sdp_value,
						is_null($oPrice->sdp_modified_datetime) ? $oPrice->sdp_created_datetime : $oPrice->sdp_modified_datetime,
						is_null($oPrice->sdp_modified_ipv4_id) ? $oPrice->sdp_ipv4_id : $oPrice->sdp_modified_ipv4_id
					);
		}

		if(is_object($oDomain) && !empty($oDomain))
		{
			$iDomainId = $oDomain->sdo_id;
			
			$this->oDbModel->updateDomain($iDomainId, $sName, $bActive, $bHosting);
			
		}else
			$iDomainId = $this->oDbModel->insertDomain($sName, $bActive, $bHosting);
		
		if(intval($iDomainId) > 0 && is_array($aPrices) && count($aPrices) > 0)
			foreach($aPrices as $sPriceType => $sPrice)
				$this->oDbModel->insertPrice($iDomainId, $sPriceType, $sPrice);
		
		return $iDomainId;
	}
	
	public function getDomain($sName = '', $iDomainId = 0, $aGetPrices = null)
	{		
		$oDomain = $this->oDbModel->selectDomain($iDomainId, $sName);
		
		if(!is_null($aGetPrices) && is_object($oDomain) && !empty($oDomain))
			$oDomain->prices = $this->getPrice($iDomainId, $sName, $aGetPrices, true);
		
		return $oDomain;	
	}
	
	public function getPrice($iDomainId = 0, $sName = '', $mPriceType = null, $bReturnAll = false)
	{
		if(!is_array($mPriceType) && is_string($mPriceType))
			$aPriceType = array($mPriceType);
		elseif(is_array($mPriceType))
			$aPriceType = $mPriceType;
		else
			$aPriceType = null;
			
		$aResult = array();	
			
		if($iDomainId <= 0)
		{
			$oDomain = $this->oDbModel->selectDomain($iDomainId, $sName);
			
			if(is_object($oDomain) && !empty($oDomain))
				$iDomainId = $oDomain->sdo_id;
		}	
			
		if($iDomainId > 0)
		{
			foreach($this->oDbModel->selectPrice($iDomainId) as $oPrice)
				if(in_array($oPrice->sdp_type, $aPriceType))
				{
					if($bReturnAll)
						$aResult[] = $oPrice;
					else
						$aResult[$oPrice->sdp_type] = $oPrice->sdp_value;
				}
		}
		
		return $aResult;
	}
	
}