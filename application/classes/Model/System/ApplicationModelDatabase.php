<?php
/**
 * Model_System_ApplicationModelDatabase
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
class Model_System_ApplicationModelDatabase extends Model_Database
{
	function __construct(Kohana_Request $oRequest = null)
	{
		$this->path = (object) Kohana::$config->load('path');
		
		if(!is_null($oRequest))
			$this->request = $oRequest;
	}
}