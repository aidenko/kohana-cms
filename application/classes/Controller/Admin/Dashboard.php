<?php
/**
 * Controller_Admin_Dashboard
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
class Controller_Admin_Dashboard extends Controller_System_Admin
{
	public function before()
	{
		$this->setTemplateFile('admin/dashboard');
		
		parent::before();
	}
	
	public function action_index()
	{	
		//$token = Profiler::start('test', 'profiler');
		
		//$this->addStyle($this->path->css.'login-form.css', 10);
		
		//$this->setBody($this->renderControllerView());
		
		//Profiler::stop($token);
		
		//echo View::factory('profiler/stats'); 
		
		$this->setBody('sdfjdfhdjfhdfj');
	}

}	
