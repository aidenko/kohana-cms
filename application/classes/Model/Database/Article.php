<?php
/**
 * Model_Database_Article
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-03-14		Artem Kolombet		[1.0]					created
 */
class Model_Database_Article extends Model_System_ApplicationModelDatabase
{
	private $sTable = 'articles';
	
	/*public function getLanguage($iId)
	{
		return DB::select()->from("language")->where("la_id","=", $iId)->as_object()->execute(); 
	}
	
	public function getLanguages()
	{
		return DB::select()->from('language')->as_object()->execute();
	}
	
	public function getDefaultLanguage()
	{
		return DB::select()->from('language')->where('la_default', '=', '1')->as_object()->execute();
	}
	
	public function getLanguageByCode($sCode)
	{
		return DB::select()->from('language')->where('la_code', '=', $sCode)->as_object()->execute();
	}*/
	
	public function getArticles($iLimitOffset = null, $iLimitLength = null)
	{
		$oQuery = DB::select()->from($this->sTable);
		
		if($iLimitLength != null)
			$oQuery->limit($iLimitLength);
			
		if($iLimitOffset != null)
			$oQuery->offset($iLimitOffset);
			
		return $oQuery->as_object()->execute();
	}
	
	public function getCountArticles()
	{
		$oQuery = DB::select(array(DB::expr('COUNT(id)'), 'total_articles'))->from($this->sTable);

		return $oQuery->as_object()->execute()->get('total_articles', 0);;
	}
	
	public function getArticle($iId)
	{
		$aArticle = DB::select()->from($this->sTable)->where("id","=", $iId)->as_object()->execute();
		
		if(count($aArticle) > 0)
			return $aArticle[0];
			
		return null;	 
	}
}