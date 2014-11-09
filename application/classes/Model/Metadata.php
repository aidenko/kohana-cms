<?php
/**
 * Model_Metadata
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-04-15		Artem Kolombet		[1.0]					created
 */
class Model_Metadata extends Model_System_ApplicationModel
{
	function __construct()
	{
		$this->loadDbModel();
	}	
	
	public function getMetadata($iItemId, $iItemType, $sDataType)
	{
		return $this->oDbModel->getMetadata($iItemId, $iItemType, $sDataType);
	}
	
	public function getKeywords($iItemId, $iItemType)
	{
		return $this->getMetadata($iItemId, $iItemType, 1);
	}
	
	public function getDescription($iItemId, $iItemType)
	{
		return $this->getMetadata($iItemId, $iItemType, 2);
	}
	
	public function getTitle($iItemId, $iItemType)
	{
		return $this->getMetadata($iItemId, $iItemType, 3);
	}
	
	public function getTypeNameById($iTypeId = null)
	{
		return $this->oDbModel->getTypeNameById($iTypeId);
	}
	
	public function getTypeIdByName($sTypeName = null)
	{
		return $this->oDbModel->getTypeIdByName($sTypeName);
	}
}