<?php
/**
 * Model_Language
 * 
 * @author Artem Kolombet
 * @copyright 2013
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2013-08-24		Artem Kolombet		[1.0]					created
 */
class Model_Language extends Model_System_ApplicationModel
{
	private $oDefaultLanguage = null;
	
	function __construct()
	{
		$this->loadDbModel();
	}	
	
	public function getLanguage($iId) { return $this->oDbModel->getLanguage($iId); }
	
	public function getLanguages() { return $this->oDbModel->getLanguages(); }
	
	public function getDefaultLanguage()
	{
		if(is_null($this->oDefaultLanguage))
			$this->oDefaultLanguage = $this->oDbModel->getDefaultLanguage();
		
		return $this->oDefaultLanguage; 
	}
	
	public function getLanguageId($bDefault = true)
	{
		//$iLaId = null;
		
		$sLaCode = Request::current()->param('lang');
		
		if($bDefault && (is_null($sLaCode) or $sLaCode == ''))
		{
			$aLa = $this->getDefaultLanguage();
			
			if(is_object($aLa) && count($aLa) > 0)
				$sLaCode = $aLa[0]->la_code;
		}	
		
		return $this->getLanguageIdByCode($sLaCode);
		
		//return $iLaId;
	}
	
	public function DEPRECATED_getLanguageId($bDefault = true)
	{
		$iLaId = Request::current()->param('la_id');
		
		if($bDefault && (is_null($iLaId) or $iLaId == 0))
		{
			$aLa = $this->getDefaultLanguage();
			
			if(is_object($aLa) && count($aLa) > 0)
				$iLaId = $aLa[0]->la_id;
		}	
		
		return $iLaId;
	}
	
	public function getLanguageCode($iLaId = null)
	{	
		if(!is_null($iLaId))
			$aLa = $this->getLanguage($iLaId);
		else
			$aLa = $this->getDefaultLanguage();
		
		if(is_object($aLa) && count($aLa) > 0)
			return $aLa[0]->la_code;
		
		return null;
	}
	
	public function getLanguageIdByCode($sCode = null)
	{
		$aLa = null;
		
		if(!is_null($sCode))
			$aLa = $this->oDbModel->getLanguageByCode($sCode);
		
		if(is_object($aLa) && count($aLa) > 0)
			return $aLa[0]->la_id;
		
		return null;
	}
}