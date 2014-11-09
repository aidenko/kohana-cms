<?php
/**
 * Controller_Template_Main_Block_Articleview
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-04-02		Artem Kolombet		[1.0]					created
 */
class Controller_Template_Main_Block_Articleview extends Controller_Front
{
	/*public function before()
	{
		$this->setTemplateFile('block/main');
		
		parent::before();
	}*/
	
	public function action_index()
	{
		$oArticle = new Model_Article;
		
		$this->response->body(View::factory('template/main/block/article_view', array('oArticle' => $oArticle->getArticle(1))));
	}
}	