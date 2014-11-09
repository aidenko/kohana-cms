<?php
/**
 * Controller_Template_Main_Block_Footer
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
class Controller_Template_Main_Block_Footer extends Controller_System_Module
{
	public function action_index()
	{
		//$ga = (object) Kohana::$config->load('ga');
		
		$this->response->body(View::factory($this->path->view_template.'main/block/footer', array('tracking' => (object) Kohana::$config->load('tracking'))));
	}
}	