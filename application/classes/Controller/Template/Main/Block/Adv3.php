<?php
/**
 * Controller_Template_Main_Block_Adv3
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-04-19		Artem Kolombet		[1.0]					created
 */
class Controller_Template_Main_Block_Adv3 extends Controller_System_Module
{
	public function action_index()
	{
		$ads = (object) Kohana::$config->load('ads');
		
		if($ads->show_ads === true && $ads->adv3 === true)
			$this->response->body(View::factory($this->path->view_template.'main/block/adv3'));
	}
	
	public function getStyles()
	{
		$ads = (object) Kohana::$config->load('ads');
		
		if($ads->show_ads === true && $ads->adv3 === true)
			return array(
				array('path' => $this->path->css_template.'main/advertisement.css', 'order' => 10)
			);
	}
}	