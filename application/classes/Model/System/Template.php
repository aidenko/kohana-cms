<?php
/**
 * Model_System_Template
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-04-01		Artem Kolombet		[1.0]					created
 */
 
class Model_System_Template extends Model_System_System
{
	private $sTemplateName = 'main';
	private $sTemplateFile = '';
	//private $path = null;
	private $aSockets = array();
	
	function __construct($oRequest, $sTemplateName = '')
	{
		parent::__construct($oRequest);
		$this->setTemplateName($sTemplateName);
	}
	
	public function setTemplateName($sName = '')
	{
		$this->sTemplateName = $sName;
		
		return $this;
	}
	
	public function getTemplateName()
	{
		return $this->sTemplateName;
	}
	
	public function getTemplatePath()
	{
		return ($this->getTemplateName() != '' ? $this->path->view_template.$this->getTemplateName().'/' : '');
	}
	
	/*public function getTemplateIndex()
	{
		return $this->getTemplatePath().'/index';
	}*/
	
	public function setTemplateFile($sFile = '')
	{
		$this->sTemplateFile = $sFile;
		
		return $this;
	}
	
	public function getTemplateFilePath($bSearchInTemplate = true)
	{
		return $bSearchInTemplate ? $this->getTemplatePath().$this->sTemplateFile : $this->sTemplateFile;
	}
	
	public function getSockets()
	{
		if(is_array($this->aSockets) && !empty($this->aSockets) && count($this->aSockets) > 0)
			return $this->aSockets;
		else
		{
			$oSocket = new Model_System_Socket($this->request);
			$this->aSockets = $oSocket->setData($this->getTemplateFilePath())->getSockets();
			
			return $this->aSockets;
		}	
	}
}