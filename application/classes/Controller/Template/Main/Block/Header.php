<?php
/**
 * Controller_Template_Main_Block_Header
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-03-12		Artem Kolombet		[1.0]					created
 */
class Controller_Template_Main_Block_Header extends Controller_System_Module
{
	public function action_index()
	{
		$this->response->body(View::factory($this->path->view_template.'main/block/header', array('logo' => $this->path->img, 'url' => URL::base())));
	}
	
	public function getStyles()
	{
		return array(
			//array('path' => $this->path->css_template.'main/advertisement.css', 'order' => 10)
		);
	}
}	