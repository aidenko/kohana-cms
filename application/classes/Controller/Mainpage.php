<?php
/**
 * Controller_Mainpage
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-03-09		Artem Kolombet		[1.0]					created
 */
class Controller_Mainpage extends Controller_System_Component
{
	public function before()
	{
		$this->setTemplateFile('mainpage');
		
		parent::before();
	}
	
	public function action_index()
	{	
		
		/*$rrr = Email::factory(
			'Новый комментарий: "YYYYYYYYYYYYYYYYYYYY"', 
			View::factory(
				$this->path->view_module.'comment/new_comment_admin_notify_ru', array(
					'username' => 'TEST',
					'comment' => 'COMMECT',
					'link' => '<a href="/" target="_blank">EEEEEEEEEEEEEEEE</a>'
				))->render(), 'text/html')
    ->to('kolombetam@uawebs.net')
    ->from('kolombetam@uawebs.net', 'BLOG ADMIN - Артём Коломбет')
    ->send();
		var_dump($rrr);*/
		
		$oMetaData = new Model_Metadata;
		$oArticle = new Model_Article;
		$oPagination = (object) Kohana::$config->load('pagination');
		$iPage = $this->request->param('page');
		
		$this->setTitle($oMetaData->getTitle($this->request->controller(), 2).' - Page '.$iPage);
		
		$this->setMetaKeywords($oMetaData->getKeywords($this->request->controller(), 2).', page '.$iPage);
		$this->setMetaDescription($oMetaData->getDescription($this->request->controller(), 2).' - Page '.$iPage);
		
		$this->addStyle($this->path->css_template.$this->getTemplateName().'/articles.css', 2);
		$this->addStyle($this->path->css_template.$this->getTemplateName().'/article-content.css', 2);
		$this->addStyle($this->path->css_template.$this->getTemplateName().'/pagination.css', 2);
		
		$this->setBody(
			View::factory(
				$this->path->view_template.'main/block/main', 
				array('aArticles' => $oArticle->getArticles(
					($iPage - 1) * $oPagination->default['items_per_page'],
					$oPagination->default['items_per_page']),
					'sPagination' => Pagination::factory(array('total_items' => $oArticle->getCountArticles()))->route_params(array('controller' => 'mainpage', 'action' => 'index'))
				))->render()
		);
		//$token = Profiler::start('test', 'profiler');
		
		//$this->addStyle($this->path->css.'login-form.css', 10);
		
		//$this->setBody($this->renderControllerView());
		
		//Profiler::stop($token);
		
		//echo View::factory('profiler/stats'); 
		
		
	}
}	
