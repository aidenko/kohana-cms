<?php
/**
 * Controller_Template_Main_Block_Main
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
class Controller_Template_Main_Block_Main extends Controller_System_Module
{
	/*public function before()
	{
		$this->setTemplateFile('block/main');
		
		parent::before();
	}*/
	
	public function action_index()
	{
		$oArticle = new Model_Article;
		$oPagination = (object) Kohana::$config->load('pagination');
		$iPage = $this->request->param('page');
		
		$this->response->body(
			View::factory(
				$this->path->view_template.'main/block/main', 
				array('aArticles' => $oArticle->getArticles(
					($iPage - 1) * $oPagination->default['items_per_page'],
					$oPagination->default['items_per_page']),
					'sPagination' => Pagination::factory(array('total_items' => $oArticle->getCountArticles()))->route_params(array('controller' => 'mainpage', 'action' => 'index'))
				)));
	}
}	