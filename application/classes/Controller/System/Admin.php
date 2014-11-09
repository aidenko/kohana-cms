<?php
/**
 * Controller_System_Admin
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-05-04		Artem Kolombet		[1.0]					created
 */
class Controller_System_Admin extends Controller_System_Component
{
	public function before()
	{
		$this->setTemplateName('');
		
		parent::before();
		
		$this->clearScripts()->clearStyles();
		
		$this->addStyle($this->path->css_admin.'general.css', 1);
		//$this->addStyle($this->path->css.'comment.css', 3);
	}
	
	public function action_index()
	{	
		//$token = Profiler::start('test', 'profiler');
		
		//$this->addStyle($this->path->css.'login-form.css', 10);
		
		//$this->setBody($this->renderControllerView());
		
		//Profiler::stop($token);
		
		//echo View::factory('profiler/stats'); 
		
		
	}
}	
