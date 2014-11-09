<?php
/**
 * Controller_Article
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
class Controller_Article extends Controller_System_Component
{
	public function before()
	{
		$this->setTemplateFile('article');
		
		parent::before();
		
		$this->addStyle($this->path->css_template.$this->getTemplateName().'/article-content.css', 2);
		$this->addScript($this->path->js.'cp.js', 1, 'footer');
		//$this->addStyle($this->path->css.'comment.css', 3);
	}
	
	public function action_index()
	{	
		//$token = Profiler::start('test', 'profiler');
		
		//$this->addStyle($this->path->css.'login-form.css', 10);
		
		//$this->setBody($this->renderControllerView());
		
		//Profiler::stop($token);
		
		//echo View::factory('profiler/stats'); 
		
		
	}
	
	public function action_view()
	{
		//$token = Profiler::start('test', 'profiler');
		
		$oArticle = new Model_Article;
		$oMetaData = new Model_Metadata;
		
		$oArticle = $oArticle->getArticle($this->request->param('id'));
		
		$this->setTitle($oArticle->title);
		$this->setMetaKeywords($oMetaData->getKeywords($this->request->param('id'), 1));
		$this->setMetaDescription($oMetaData->getDescription($this->request->param('id'), 1));
		
		$this->setBody(View::factory($this->getView('block/article_view'), array('oArticle' => $oArticle)));
		
		//Profiler::stop($token);
		
		//echo View::factory('profiler/stats'); 
	}
}	
