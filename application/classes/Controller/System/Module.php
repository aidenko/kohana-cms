<?php
/**
 * Controller_System_Module
 * 
 * @author Artem Kolombet
 * @copyright 2013
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2013-12-22		Artem Kolombet		[1.0]					created
 */
class Controller_System_Module extends Controller
{
	public $iLaId = null;
	public $sLaCode = null;
	
	public $path = null;
	
	protected $lang = 'en';
	
	public function before()
	{
		parent::before();
		
		$this->path = (object) Kohana::$config->load('path');
		
		$this->sLaCode = $this->request->param('lang');
		
		$oLanguage = new Model_Language;
		
		$this->iLaId = $oLanguage->getLanguageId(false);
		
		if($this->sLaCode == '' or is_null($this->sLaCode))
			$this->sLaCode = $oLanguage->getLanguageCode($this->iLaId);
		
		$this->setLang($this->sLaCode);
		
		//I18n::lang($this->sLaCode);
		//I18n::load($this->sLaCode.'/module'.strtolower($this->request->controller()));

		$this->setBody('');
	}
	
	/*
	public function action_index()
	{
		
	}
	*/
	
	public function getLangFile()
	{
		return $this->sLaCode.'/module'.strtolower($this->request->controller());
	}
	
	public function setBody($sBody)
	{
		$this->response->body($sBody);
	}
	
	public function setLang($sLang)
	{
		$this->lang = $sLang;
	}
	
	public function getControllerView()
	{
		return strtolower(str_replace('_', '/', $this->request->directory()).'/'.$this->request->controller());
	}
	
	public function renderControllerView($sView= null, $aData = array())
	{
		$sViewName = (!is_null($sView) && !empty($sView)) ? $sView : $this->getControllerView();
		
		$oView = View::factory($sViewName);
		
		if(is_object($oView))
		{
			if(is_array($aData))
				foreach($aData as $p => $v)
					$oView->set($p, $v);
					
			return $oView;		
		}
		else
			return null;
	}
	
	public function getStyles()
	{
		return array();
	}
	
	public function getScripts()
	{
		return array();
	}
	
	private function renderSockets()
	{
		$aReplacement = array();
		
		$oSocket = new Model_System_Socket($this->request);
			//var_dump($oSocket->setData($this->getControllerView())->getSockets());

		foreach($oSocket->setData($this->getControllerView())->getSockets() as $oSocket)
			$aReplacement[$oSocket->node] = Request::factory($oSocket->controller.'/'.$oSocket->method.$oSocket->param)->execute();		
		
		$this->response->body(str_replace(array_keys($aReplacement), array_values($aReplacement), $this->response->body()));
	}
	
	public function after()
	{
		parent::after();

		$this->renderSockets();
	}
}
	