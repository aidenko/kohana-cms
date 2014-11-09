<?php
/**
 * Controller_System_Component
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
class Controller_System_Component extends Controller_Template
{
	public $template = null;//it is an object
	public $template_file = 'index';
	public $sTemplateName = 'main';
	//public $template = 'base/base';
	//public $template = 'template/main/index';
	protected $lang = 'en';
	
	public $iLaId = null;
	public $sLaCode = null;
	
	public $aStyles = array();
	public $aScripts = array();
	public $aMetaData = array();
	
	public $path = null;
	public $oTemplate = null;
	
	
	public function before()
	{		
		//$this->profiler_token = Profiler::start('test', 'profiler');
		/*$options = Kohana::$config->load('path');
		
		var_dump($options);*/
		
		$this->path = (object) Kohana::$config->load('path');
		
		/*if($this->getTemplateFile() != '')
		{*/
			$this->oTemplate = new Model_System_Template($this->request, $this->sTemplateName);
		
			//$this->template = $this->oTemplate->getTemplateIndex();
			$this->oTemplate->setTemplateFile($this->getTemplateFile());
			$this->template = $this->oTemplate->getTemplateFilePath();
			
			parent::before();
			
			$this->sLaCode = $this->request->param('lang');
			
			$oLanguage = new Model_Language;
			
			$this->iLaId = $oLanguage->getLanguageId();
			
			if($this->sLaCode == '' or is_null($this->sLaCode))
				$this->sLaCode = $oLanguage->getLanguageCode($this->iLaId);
			
			$this->setLang($this->sLaCode);
			
			//I18n::lang($this->sLaCode);
			//I18n::lang($this->sLaCode.'/'.strtolower($this->request->controller()));
			//var_dump($this->sLaCode.'/'.strtolower($this->request->controller()));
			
			$this->addStyle($this->path->css.'reset.css');
			$this->addStyle($this->path->css_template.$this->getTemplateName().'/general.css', 1);
			//$this->addStyle($this->path->css_template.$this->getTemplateName().'/advertisement.css', 2);
			//$this->addStyle($this->path->jquery.'themes/base/minified/jquery-ui.min.css', 2);
			
			//$this->addScript($this->path->jquery.'jquery-2.0.3.min.js');
			//$this->addScript($this->path->js.'config.js', 1);
			//$this->addScript($this->path->js.'common.js', 2);	
		/*}else
			parent::before();	*/
		
		$this->setTitle('');
		$this->setBody('');
	}
	
	public function action_index()
	{
		
	}
	
	public function getLangFile()
	{
		return $this->sLaCode.'/'.strtolower($this->request->controller());
	}
	
	public function getView($sRelPath/*, $sTemplateName = null*/)
	{
		/*if(is_null($sTemplateName) or empty($sTemplateName))
			$sTemplateName = $this->getTemplateName();*/
		
		return $this->oTemplate->getTemplatePath().$sRelPath;
	}
	
	public function setTemplateName($sName = '')
	{
		$this->sTemplateName = $sName;
		
		return $this;
	}
	
	public function getTemplateName()
	{
		//return $this->oTemplate->getTemplateName();
		return $this->sTemplateName;
	}
	
	public function setTemplateFile($sName = 'index')
	{
		$this->template_file = $sName;
		
		return $this;
	}
	
	public function getTemplateFile()
	{
		return $this->template_file;
	}
	
	public function getTemplateFilePath()
	{
		return  $this->oTemplate->getTemplatePath().$this->template_file;
	}
	
	public function setLang($sLang)
	{
		$this->template->lang = $sLang;
		
		return $this;
	}
	
	public function addStyle($sPath, $iOrder = 0)
	{
		if(!in_array($sPath, Arr::pluck($this->aStyles, 'path')))		
			$this->aStyles[] = array('path' => $sPath, 'order' => $iOrder);
	}
	
	public function addScript($sPath, $iOrder = 0, $sTarget = 'head')
	{
		if(!in_array($sPath, Arr::pluck($this->aScripts, 'path')))		
			$this->aScripts[] = array('path' => $sPath, 'order' => $iOrder, 'target' => $sTarget);
	}
	
	public function insertScript($sBody, $iOrder = 0, $sTarget = 'head')
	{
		if(!in_array($sBody, Arr::pluck($this->aScripts, 'body')))		
			$this->aScripts[] = array('body' => $sBody, 'order' => $iOrder, 'target' => $sTarget);
	}
	
	public function clearStyles()
	{
		$this->aStyles = array();
		
		return $this;
	}
	
	public function clearScripts()
	{
		$this->aScripts = array();
		
		return $this;
	}
	
	public function addMetaData($sName, $sContent)
	{
		$this->aMetaData[$sName] = $sContent;
	}
	
	public function setMetaKeywords($sContent = '')
	{
		return $this->addMetaData('keywords', $sContent);
	}
	
	public function setMetaDescription($sContent = '')
	{
		return $this->addMetaData('description', $sContent);
	}
	
	public function setTitle($sTitle)
	{
		$this->template->title = $sTitle;
	}
	
	public function setBody($sBody = '')
	{
		$this->template->body = $sBody;
	}
	
	public function after()
	{	
		$this->getReferences();
		
		$this->compressCss();
		//$this->compressJs();
		
		$this->template->aHead = array(
			'title' => $this->getTitle(),
			'style' => $this->getStyles(false),
			'script' => $this->getScripts('head'),
			'meta' => $this->getMetaData()
		);
		
		$this->template->aFooter = array(
			'script' => $this->getScripts('footer'),
		);
		
		parent::after();

		$this->renderSockets();
		
		//Profiler::stop($this->profiler_token);
		
		//echo View::factory('profiler/stats'); 
	}
	
	private function compressCss() {	return $this->compress('css'); }
	
	private function compressJs() { return $this->compress('js'); }
	
	private function compress($sType = 'css')
	{
		$sContent = $sFile = '';
		
		$aTmp = array();
		
		if($sType == 'css')
			$aData = $this->getStyles();
		elseif($sType == 'js')
			$aData = $this->getScripts();
		
		if(!is_array($aData) or count($aData) <= 0)
			return;	
		
		
		
		foreach($aData as $path)
		{
			$bBody = array_key_exists('body', $path);
			
			$aTmp[] = $bBody ? $path['body'] : $path['path'];
			
			if($bBody)
				$sContent .= ($sType == 'css' ? str_replace(array("\n", "\r"), '', $path['body']) : $path['body'])."\n";
			else				
				$sContent .= "/*".$path['path']."*/"
					.($sType == 'css' ? str_replace(array("\n", "\r"), '', file_get_contents('.'.$path['path'])) : file_get_contents('.'.$path['path']))
					."\n";
		}
		
		$sCacheFolder = $sType == 'css' ? $this->path->css_cache : $this->path->js_cache;			
		
		$sFile = $sCacheFolder.md5(implode(',', $aTmp)).'.'.$sType;
		
		if(!is_dir('.'.$sCacheFolder))
			mkdir('.'.$sCacheFolder, 0755);
		
		file_put_contents('.'.$sFile, $sContent);
		if($sType == 'css')
			$this->aStyles = array(array('path' => $sFile, 'order' => 1));
		elseif($sType == 'js')	
			$this->aScripts = array(array('path' => $sFile, 'order' => 1));
			
		return;	
	}
	
	private function getTitle()
	{
		return $this->template->title;
	}
	
	private function getStyles(/*$sTarget = null, */$bSort = true)
	{
		/*if($sTarget == null)
			$aStyles = $this->aStyles;
		else
		{
			$aStyles = array();
			
			foreach($this->aStyles as $s)
				if($s['target'] == $sTarget)
					$aStyles[] = $s;
		}*/
		
		$aStyles = $this->aStyles;
		
		if($bSort)
			usort($aStyles, array('Controller_System_Component', 'sortByOrder'));
		
		return $aStyles;	
	}
	
	private function getScripts($sTarget = null, $bSort = true)
	{
		if($sTarget == null)
			$aScripts = $this->aScripts;
		else
		{
			$aScripts = array();
			
			foreach($this->aScripts as $s)
				if($s['target'] == $sTarget)
					$aScripts[] = $s;
		}
		
		if($bSort)
			usort($aScripts, array('Controller_System_Component', 'sortByOrder'));
		
		return $aScripts;	
	}
	
	public function sortByOrder($a, $b)
	{
		return intval($a['order'] > $b['order']);	
	}
	
	public function getMetaData()
	{
		return $this->aMetaData;
	}
	
	
	public function getControllerView()
	{
		return strtolower($this->request->controller());
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
	
	private function getReferences()
	{
		foreach($this->oTemplate->getSockets() as $oSocket)
		{
			$sModule = 'Controller_'.str_replace(' ', '_', ucwords(str_replace('/', ' ', $oSocket->controller)));

			$oModule = new $sModule($this->request, $this->response);
		
			$oModule->before();
			
			if(is_array($oModule->getStyles()))
				foreach($oModule->getStyles() as $a)
					$this->addStyle($a['path'], $a['order']);
			
			if(is_array($oModule->getScripts()))	
				foreach($oModule->getScripts() as $a)
					if(array_key_exists('path', $a))
						$this->addScript($a['path'], $a['order'], array_key_exists('target', $a) ? $a['target'] : 'head');
					elseif(array_key_exists('body', $a))
						$this->insertScript($a['body'], $a['order'], array_key_exists('target', $a) ? $a['target'] : 'head');					
		}	
		
		return ;
	}
	
	private function renderSockets()
	{
		$aReplacement = array();

		foreach($this->oTemplate->getSockets() as $oSocket)
			$aReplacement[$oSocket->node] = Request::factory($oSocket->controller.'/'.$oSocket->method.$oSocket->param)->execute();
		
		$this->response->body(str_replace(array_keys($aReplacement), array_values($aReplacement), $this->response->body()));
	}
	

}
	