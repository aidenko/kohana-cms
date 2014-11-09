<?php
/**
 * Model_Database_Metadata
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
class Model_Database_Metadata extends Model_System_ApplicationModelDatabase
{	
	private $sTable = 'meta_data';
	private $sTableType = 'meta_data_type';
	
	/*public function getArticles()
	{
		return DB::select()->from('articles')->as_object()->execute();
	}
	
	public function getArticle($iId)
	{
		$aArticle = DB::select()->from("articles")->where("id","=", $iId)->as_object()->execute();
		
		if(count($aArticle) > 0)
			return $aArticle[0];
			
		return null;	 
	}*/
	
	public function getMetadata($sItemId, $iItemType, $sDataType)
	{
		if(is_string($sDataType) && !is_numeric($sDataType))
			$iDataType = $this->getTypeIdByName($sDataType);
		else
			$iDataType = $sDataType;
			
		if($iDataType > 0 && intval($iItemType) > 0)
		{
			$oQuery = DB::select()
								->from($this->sTable)
								->where('ct_id', '=', $iItemType)				
								->where('mdt_id', '=', $iDataType);

			if(is_numeric($sItemId))
				$oQuery->where('item_id', '=', $sItemId);
			else
				$oQuery->where('item_name', '=', $sItemId);
						
			$aData = $oQuery->as_object()->execute();
								
			if(/*is_array($aData) && */count($aData) > 0)
				return $aData[0]->md_text;					
		}		
		
		return '';
	}
	
	public function getTypeNameById($iTypeId = null)
	{
		if(!is_null($iTypeId) && is_numeric($iTypeId))
		{
			$aType = DB::select()->from($this->sTableType)->where('mdt_id', '=', $iTypeId)->as_object()->execute();
			
			if(is_array($aType) && count($aType) > 0)
				return $aType[0]->mdt_name;
		}
		
		return '';
	}
	
	public function getTypeIdByName($sTypeName = null)
	{
		if(!is_null($sTypeName))
		{
			$aType = DB::select()->from($this->sTableType)->where('mdt_name', '=', $sTypeName)->as_object()->execute();
			
			if(/*is_array($aType) && */count($aType) > 0)
				return $aType[0]->mdt_id;
		}
		
		return 0;
	}
}