<?php
/**
 * Model_System_System
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-05-03		Artem Kolombet		[1.0]					created
 */
 
class Model_System_System extends Model
{
	protected $path = null;
	protected $request = null;
	
	function __construct(Kohana_Request $oResuest = null)
	{
		$this->path = (object) Kohana::$config->load('path');
		if(!is_null($oResuest))
			$this->request = $oResuest;
	}
}