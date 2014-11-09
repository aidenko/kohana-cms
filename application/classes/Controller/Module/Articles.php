<?php
/**
 * Controller_Module_Articles
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
class Controller_Module_Articles extends Controller_System_Module
{
	public function action_get_all_articles()
	{
		$oArticle = new Model_Article;

		$this->setBody(View::factory($this->path->view_module.'articles/all_articles', array('aArticles' => $oArticle->getArticles(), 'lang' => $this->getLangFile())));
	}
	
	public function getStyles()
	{
		return array(
			array('path' => $this->path->css.'module-articles.css', 'order' => 3)
		);
	}
}