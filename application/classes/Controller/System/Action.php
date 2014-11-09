<?php
/**
 * Controller_System_Action
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-05-13		Artem Kolombet		[1.0]					created
 */
class Controller_System_Action extends Controller
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
	}
	
	/*
	public function action_index()
	{
		
	}
	*/
	
	public function getLangFile()
	{
		return $this->sLaCode.'/action'.strtolower($this->request->controller());
	}
	
	public function setLang($sLang)
	{
		$this->lang = $sLang;
	}
}
	