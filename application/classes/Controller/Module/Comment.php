<?php
/**
 * Controller_Module_Comment
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
class Controller_Module_Comment extends Controller_System_Module
{
	public function action_index()
	{	
		//$token = Profiler::start('test', 'profiler');
		
		//$this->addStyle($this->path->css.'login-form.css', 10);
		
		//$this->setBody($this->renderControllerView());
		
		//Profiler::stop($token);
		
		//echo View::factory('profiler/stats'); 
		
		//$this->response->body('dfsdfs');
		
	}
	
	public function action_item_comment()
	{
		$oComments = new Model_Comment;
		
		$iCtId = $this->request->param('ct_id');
		$iItemId = $this->request->param('id');
		
		$oPagination = (object) Kohana::$config->load('pagination');
		
		$aComments = $oComments->getItemComments(
						$iCtId, 
						$iItemId, 
						array('cm_datetime' => 'desc'), 
						array($oPagination->default['items_per_page']));
						
		foreach($aComments as $i => &$c)
		{
			$aVotes = $oComments->getCommentPlusMinus($c->cm_id);
			
			$c->plus = $aVotes['+'];
			$c->minus = $aVotes['-'];
		}
		
		$this->setBody(
			View::factory(
				 	$this->path->view_module.'comment/top_comments', 
					array(
						'sComments' => View::factory($this->path->view_module.'comment/comments_list', array('aComments' => $aComments, 'lang' => $this->getLangFile()))->render(),
						'iTotal' => $oComments->getCountItemComments($iCtId, $iItemId),
						'sAllUrl' => Route::get('comments')->uri(array('action' => 'all_item_comment', 'ct_id' => $iCtId, 'id' => $iItemId)),
						'lang' => $this->getLangFile()	
					)
			)
		);
	}
	
	public function action_post_form()
	{
		$session = Session::instance();
		$aErrors = $session->get_once('create-comment-error');
		$aComment = $session->get_once('create-comment-data');
		$sSuccessMessage = $session->get_once('create-comment-success');
		
		if(!is_array($aErrors))
			$aErrors = array();
			
		if(!is_array($aComment))
			$aComment = array();	
		
		$oRecaptcha = (object) Kohana::$config->load('recaptcha');
			
		require Kohana::find_file('vendor', 'recaptcha/recaptchalib', 'php');

		$this->setBody(View::factory(
			$this->path->view_module.'comment/post_form', 
			array(
				'lang' => $this->getLangFile(),
				//'config' => $this->path->js.'ck-editor-modulecomment.js',
				'ct_id' => $this->request->param('ct_id'),
				'id' => $this->request->param('id'),
				'action' => Route::get('action')->uri(array('controller' => 'comment', 'action' => 'create_comment')),
				'aErrors' => $aErrors,
				'sSuccessMessage' => $sSuccessMessage,
				'aCommentData' => $aComment,
				'sRecaptcha' => recaptcha_get_html($oRecaptcha->public_key)
				)
			)
		);
	}
	
	public function getStyles()
	{
		return array(
			array('path' => $this->path->css.'comment.css', 'order' => 3),
		);
	}
	
	public function getScripts()
	{
		return array(
			array('path' => $this->path->ck_editor.'ckeditor.js', 'order' => 3, 'target' => 'footer'),
      array('path' => $this->path->js.'jquery-2.1.0.min.js', 'order' => 4, 'target' => 'footer'),
      array('path' => $this->path->js.'modulecomment.js', 'order' => 5, 'target' => 'footer'),
      array('body' => 'oComment.init();', 'order' => 6, 'target' => 'footer')
		);
	} 
}	
