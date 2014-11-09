<?php
/**
 * Model_System_ApplicationModel
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
class Model_System_ApplicationModel extends Model
{
	public $oDbModel = null;
	//public static $sDbModelName = null;

	function __construct(Kohana_Request $oRequest = null, $bLoadDbModel = true)
	{
		$this->path = (object) Kohana::$config->load('path');
		if(!is_null($oRequest))
			$this->request = $oRequest;
			
		if($bLoadDbModel)	
			$this->loadDbModel();	
	}
	
	public function loadDbModel()
	{
		if(!is_null($this->oDbModel) or !is_object($this->oDbModel))
		{
			$sDbModel = str_replace('Model', 'Model_Database', get_class($this));
			
			//$this->sDbModelName = $sDbModel;
		
			$this->oDbModel = new $sDbModel(((isset($this->request) && !is_null($this->request)) ? $this->request : null));	
		}

		return true;
	}
}