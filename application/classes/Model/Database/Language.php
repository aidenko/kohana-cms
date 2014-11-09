<?php
/**
 * Model_Database_Language
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
class Model_Database_Language extends Model_System_ApplicationModelDatabase
{
	private $sTable = 'language';
	
	public function getLanguage($iId)
	{
		return DB::select()->from($this->sTable)->where("la_id","=", $iId)->as_object()->execute(); 
	}
	
	public function getLanguages()
	{
		return DB::select()->from($this->sTable)->as_object()->execute();
	}
	
	public function getDefaultLanguage()
	{
		return DB::select()->from($this->sTable)->where('la_default', '=', '1')->as_object()->execute();
	}
	
	public function getLanguageByCode($sCode)
	{
		return DB::select()->from($this->sTable)->where('la_code', '=', $sCode)->as_object()->execute();
	}
}