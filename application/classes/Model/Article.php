<?php
/**
 * Model_Article
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-03-14		Artem Kolombet		[1.0]					created
 */
class Model_Article extends Model_System_ApplicationModel
{
	function __construct()
	{
		$this->loadDbModel();
	}	
	
	public function getArticles($iLimitOffset = null, $iLimitLength = null)
	{
		return $this->oDbModel->getArticles($iLimitOffset, $iLimitLength);
	}
	
	public function getCountArticles()
	{
		return $this->oDbModel->getCountArticles();
	}
	
	public function getArticle($iId)
	{
		return $this->oDbModel->getArticle($iId);
	}
	
	
}