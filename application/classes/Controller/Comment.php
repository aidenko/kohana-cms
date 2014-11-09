<?php
/**
 * Controller_Comment
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-04-22		Artem Kolombet		[1.0]					created
 */
class Controller_Comment extends Controller_System_Component
{
	public function before()
	{
		$this->setTemplateFile('comment');
		
		parent::before();
		
		$this->addStyle($this->path->css_template.$this->getTemplateName().'/article-content.css', 2);
		$this->addStyle($this->path->css_template.$this->getTemplateName().'/pagination.css', 4);
		$this->addStyle($this->path->css.'comment.css', 3);
	}
	
	public function action_index()
	{	
		//$token = Profiler::start('test', 'profiler');
		
		//$this->addStyle($this->path->css.'login-form.css', 10);
		
		//$this->setBody($this->renderControllerView());
		
		//Profiler::stop($token);
		
		//echo View::factory('profiler/stats'); 
		
		//$this->response->body('dfsdfs');
		
	}
	
	public function action_all_item_comment()
	{
		//$token = Profiler::start('test', 'profiler');
		
		$oArticle = new Model_Article;
		$oMetaData = new Model_Metadata;
		$oComments = new Model_Comment;
		
		$oPagination = (object) Kohana::$config->load('pagination');
		
		$iCtId = $this->request->param('ct_id');
		$iItemId = $this->request->param('id');
		$iPage = $this->request->param('page');
		
		$oArticle = $oArticle->getArticle($iItemId);
		
		$this->setTitle($oArticle->title.' - Комментарии - Страница '.$iPage);
		$this->setMetaKeywords($oMetaData->getKeywords($iItemId, $iCtId).', '.$oMetaData->getKeywords($this->request->controller(), 2).', page '.$iPage);
		$this->setMetaDescription($oMetaData->getDescription($iItemId, $iCtId).' '.$oMetaData->getDescription($this->request->controller(), 2).'. Страница '.$iPage);
		
		$aComments = $oComments->getItemComments(
						$iCtId, 
						$iItemId, 
						array('cm_datetime' => 'desc'), 
						array(($iPage - 1) * $oPagination->default['items_per_page'], $oPagination->default['items_per_page']));
		
		foreach($aComments as $i => &$c)
		{
			$aVotes = $oComments->getCommentPlusMinus($c->cm_id);
			
			$c->plus = $aVotes['+'];
			$c->minus = $aVotes['-'];
		}	
		
		$this->setBody(View::factory($this->getView('block/all_item_comments'), array(
			'sComments' => View::factory(
				$this->path->view_module.'comment/comments_list', 
				array(
					'aComments' => $aComments, 
					'sPagination' => Pagination::factory(array('total_items' => $oComments->getCountItemComments($iCtId, $iItemId)))->route_params(array('action' => 'all_item_comment', 'ct_id' => $iCtId, 'id' => $iItemId)),
                    'lang' => $this->getLangFile()
			)),
			'sItemPreview' => $oArticle->preview_text,
			'sPreviewTitle' => $oArticle->title,
			'sBackLink' => Route::get('article')->uri(array('id' => $iItemId)),
			'lang' => $this->getLangFile()
			
			)));
		//echo View::factory('profiler/stats'); 
	}
}	
