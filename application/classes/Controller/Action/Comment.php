<?php
/**
 * Controller_Action_Comment
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-05-13		Artem Kolombet		[1.0]					created
 */
class Controller_Action_Comment extends Controller_System_Action
{
	public function action_create_comment()
	{
		$oComments = new Model_Comment($this->request);
		
		$aCommentData = array(
			'cm_name' => $this->request->post('cm_name'),
			'cm_email' => $this->request->post('cm_email'),
			'cm_text' => $this->request->post('cm_text'),
			'ct_id' => $this->request->post('ct_id'),
			'id' => $this->request->post('id'),
			'botik' => $this->request->post('botik')
		);
		
		$lang = $this->getLangFile();
		
		if($oComments->validComment($aCommentData))
		{
			$oComments->createComment($aCommentData);
			
			$oComments->addSubscribtion($this->request->post('cm_email'), intval($this->request->post('ct_id')), intval($this->request->post('id')), $this->request->post('cm_name'));
			
			$session = Session::instance();
			$session->set('create-comment-success', I18n::get('premoderate-message', $lang));
			
			$oArticleModel = new Model_Article;
			
			$oArticle = $oArticleModel->getArticle($this->request->post('id'));

			$oComments->notifyAdmin(
				array(
					'username' => $this->request->post('cm_name'),
					'title' => $oArticle->title,
					'url' => URL::site(Route::get('article')->uri(array('id' => (int) $this->request->post('id'))), true),
					'comment' => $this->request->post('cm_text')
				),
			$this->sLaCode
			);
		}
		else
		{
			$aErrors = $oComments->getValidationErrors();
			
			foreach($aErrors as $name => &$text)
				$aErrors[$name] = I18n::get($text, $lang);
			
			$session = Session::instance();
			$session->set('create-comment-error', $aErrors);
			$session->set('create-comment-data', $aCommentData);
		}
		
		HTTP::redirect($this->request->referrer());
				
	}
	
	public function action_notify_comment()
	{
		$oComment = new Model_Comment();
		
		return $oComment->notifyUsers();
	}
}