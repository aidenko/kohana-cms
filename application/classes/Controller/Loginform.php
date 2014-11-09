<?php defined('SYSPATH') OR die('No Direct Script Access');

/**
 * Controller_Loginform
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
class Controller_Loginform extends Controller_Fronttemplate
{
	private $oLanguage = null;
	
	public function before()
	{
		parent::before();
		
		$this->oLanguage = new Model_Language();
		
		Auth::instance()->logout();
	}
	
	public function action_index()
	{	
		$this->addStyle($this->path->css.'login-form.css', 10);
		
		$this->setBody(View::factory($this->getControllerView())
			->set('languages', $this->oLanguage->getLanguages())
			->set('la_id', $this->iLaId)
			->set('la_code', $this->sLaCode)
			->set('url', Route::get('loginform')->uri(array('lang' => $this->sLaCode)))
			//->set('url', Route::get('loginform')->uri(array('lang' => $this->sLaCode, 'action' => 'index', 'controller' => 'loginform')))
			->set('form_url', Route::get('loginform')->uri(array('lang' => $this->sLaCode, 'action' => 'login'))));
		
		//Profiler::stop($token);
		
		//echo View::factory('profiler/stats'); 
	}
	/*
	public function _action_create_member()
	{
		try
		{
		
			$user = ORM::factory('User')->create_user($_POST, array(
				'username',
				'password',
				'email',
				));
			$user = ORM::factory('User')
				->create_user($_POST, array('username', 'email', 'password')) // Регистрируем пользователя
				->add('roles', ORM::factory('Role', array('name' => 'login')))
				->add('roles', ORM::factory('Role', array('name' => 'admin')))
				;  // Добавляем роль login
			
			// Регистрация успешна
		}
		catch(ORM_Validation_Exception $e)
		{
			$errors = $e->errors(); 
			
			var_dump( $errors);
			// Допущены ошибки при вводе данных
		}
	}*/
	
	public function action_login()
	{
		$post = $this->request->post();
		
		if(array_key_exists('username', $post) && array_key_exists('password', $post))
			Auth::instance()->login($post['username'], $post['password']);
		else
			echo "Wrong parameters";
		
		$bLoged = Auth::instance()->logged_in();
		
		//var_dump($bLoged);
		
		if($bLoged)
			HTTP::redirect(Route::get('dashboard')->uri(array('lang' => $this->sLaCode)));
		
		else
			return $this->action_index();
	}
}
