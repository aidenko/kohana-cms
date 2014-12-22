<?php
/**
 * Controller_Action_Domains
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-11-12		Artem Kolombet		[1.0]					created
 */
class Controller_Action_Domains extends Controller_System_Action
{
	public function action_index()
	{
		$objData = json_decode(file_get_contents("php://input"));
		
		$oDomain = new Model_Domains;
		
		$this->oConfig = (object) Kohana::$config->load('sell_domains');
	
		$aDomains = array();
		
		foreach($oDomain->selectDomains(0, $this->oConfig['sell_price']) as $domain)
			$aDomains[] = array('sdo_name' => $domain->sdo_name, 'price' => $this->calculatePrice($domain->prices[$this->oConfig['sell_price']]));	
		
		return print_r(json_encode(array('domain' => $aDomains, 'currency' => $this->oConfig['sell_currency'])));
	}
	
	private function calculatePrice($fPrice = 0.00)
	{
		return round($fPrice * (1 + $this->oConfig['sell_interest']));
	}
	
	public function action_get_template_list()
	{
		echo View::factory($this->path->view_template.'main/block/domains_list', array('lang' => $this->getLangFile()))->render();
	}
	
	public function get_is_available()
	{
		$sDomains = '';
		
		$objData = json_decode(file_get_contents("php://input"));
		
		var_dump($objData);
		
	}
	
	public function create_comment()
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
	
	public function notify_comment()
	{
		$oComment = new Model_Comment();
		
		return $oComment->notifyUsers();
	}
}