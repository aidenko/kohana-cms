<?php
/**
 * Model_System_Socket
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-05-03		Artem Kolombet		[1.0]					created
 */
class Model_System_Socket extends Model_System_System
{
	private $aSockets = array();
	private $bIsFile = false;
	private $sContent = null;
	
	public function setData($sData = null)
	{
		try
		{
			$this->setContent(@View::factory($sData)->render());
			$this->bIsFile = true;
			
		}catch(Kohana_Exception $e)
		{
			$this->setContent($sData);	
		}
		
		return $this;	
	}
	
	public function setFile($sFile = '')
	{
		if(!empty($sFile) && !is_null($sFile))
		{
			$this->sFile = $sFile;
			return true;	
		}
		
		return false;
	}
	
	public function setContent($sContent = '')
	{
		$this->sContent = $sContent;
		return true;
	}
	
	public function getContent() { return $this->sContent; }
	
	public function getSockets()
	{
		//if($this->bIsFile)
	
		/*if((is_null($sFile) or empty($sFile)) && (is_null($sContent) or empty($sContent)))
			return array();*/
		
		if(is_array($this->aSockets) && !empty($this->aSockets) && count($this->aSockets) > 0)
			return $this->aSockets;
		
		$aSocketNode = array();
		$sPattern = '/<socket.+\/>/';
		
		/*if(!is_null($sFile) && !empty($sFile))
			preg_match_all($sPattern, @View::factory($sFile)->render(), $aSocketNode);
		elseif(!is_null($sContent) && !empty($sContent))
			preg_match_all($sPattern, $sContent, $aSocketNode);
		else
			return array();	*/
		
		//var_dump($this->getContent());
		
		preg_match_all($sPattern, $this->sContent, $aSocketNode);
		
		if(count($aSocketNode) > 0)
		{
			foreach($aSocketNode[0] as $n)
			{
				$this->aSockets[] = (object) array(
					'name' => $this->getSocketAttribute('name', $n),
					'controller' => $this->getSocketAttribute('controller', $n),
					'method' => $this->getSocketAttribute('method', $n),
					'param' => $this->getSocketAttribute('param', $n),
					'param' => $this->getSocketParam($this->getSocketAttribute('param', $n)),
					'node' => $n
				);	
			}	
		}
		
		return $this->aSockets;
	}
	
	public function getSocketAttribute($sAttribute, $sSocket)
	{	
		if(preg_match_all('/'.$sAttribute.'=[\'\"]{1}([\d\w=\/;\{\}]+)[\"\']{1}+/', $sSocket, $aSocketParse) == 1 && count($aSocketParse[1]) > 0)
			return $aSocketParse[1][0];
		else
			switch($sAttribute)
			{
				case 'method':
					return 'index';
				break;

				default:
					return '';
				break;
			}
	}
	
	private function getSocketParam($sParam = '')
	{
		$aResult = array();
		
		$sPattern = '/\{([\w\d]+)\}/';
		
		if(preg_match_all($sPattern, $sParam, $aResult))
		{
			$aResult = $aResult[1];
			foreach($aResult as $k => &$p)
				$aResult[$k] = $this->request->param($p);
			
			unset($p);
			//return '/'.implode('/', $aResult);
			return preg_replace(array_fill(0, count($aResult), $sPattern), $aResult, $sParam, 1);		
		}
		
		return '';
	}
}