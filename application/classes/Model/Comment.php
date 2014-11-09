<?php
/**
 * Model_Comment
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-03-23		Artem Kolombet		[1.0]					created
 */
class Model_Comment extends Model_System_ApplicationModel
{
	private $aValidationErrors = array();
	
	function __construct($oRequest = null)
	{
		parent::__construct($oRequest);
		$this->loadDbModel();
	}	
	
	public function getComments()
	{
		$aComments = $this->oDbModel->getComments();
		
		foreach($aComments as $k => &$c)
			$c->cm_text = $this->parseBBCode($c->cm_text);
		
		return $aComments;
	}
	
	public function getItemComments($iItemType, $iItemId, $aOrderBy = array('cm_datetime' => 'DESC'), $aLimit = array(), $bActive = true, $bDeleted = false)
	{
		$aComments = $this->oDbModel->getItemComments($iItemType, $iItemId, $aOrderBy, $aLimit, $bActive, $bDeleted);
		
		foreach($aComments as $k => &$c)
			$c->cm_text = $this->parseBBCode($c->cm_text);
		
		return $aComments;
	}
	
	public function getCountItemComments($iItemType, $iItemId, $bActive = true, $bDeleted = false)
	{
		return $this->oDbModel->getCountItemComments($iItemType, $iItemId, $bActive = true, $bDeleted = false);
	}

	public function parseBBCode($sComment = '')
	{	
		$sParsedComment = preg_replace('/\[(\/?(b|i|quote|url)+)(\s??.*?)\]/', '<$1$3>', $sComment);
		
		$sParsedComment = preg_replace('/<url>(.+)<\/url>/', '<a href="$1" target="_blank">$1</a>', $sParsedComment);
		
		$sParsedComment = preg_replace(
			array('/<quote\sname\=[\'\"]([\wа-яёїъ\s\d\-]+)[\'\"]>/iu', '/<\/quote>/'), 
			array('<fieldset><legend>$1</legend>', '</fieldset>'), 
			$sParsedComment
		);
		
		return $sParsedComment;
	}
	
	public function getCommentPlusMinus($iCommentId)
	{
		$aResult = array('+' => 0, '-' => 0);
		
		foreach($this->oDbModel->getCommentPlusMinus($iCommentId) as $r)
			if($r->cv_value == '+')
				$aResult['+'] = $r->number;
			elseif($r->cv_value == '-')
				$aResult['-'] = $r->number;	
				
		return $aResult;	
	}
	
	public function validComment($aComment = array(), $bBotProtection = true)
	{
		$bValid = true;

		if($bBotProtection && $aComment['botik'] != '')
		{
			$this->aValidationErrors['botik'] = 'you-bot';
			return false;
		}
		
		if($bBotProtection)
		{
			$oRecaptcha = (object) Kohana::$config->load('recaptcha');
			require Kohana::find_file('vendor', 'recaptcha/recaptchalib', 'php');
			
			$oResponse = recaptcha_check_answer (	$oRecaptcha->private_key,
										                        Request::$client_ip,
										                        $this->request->post('recaptcha_challenge_field'),
										                        $this->request->post('recaptcha_response_field'));
										                        
			if(!$oResponse->is_valid)
			{
				$this->aValidationErrors['recaptcha-fail'] = 'recaptcha-fail';
				return false;
			} 
		}
		
		if((array_key_exists('cm_name', $aComment) && empty($aComment['cm_name'])) or !array_key_exists('cm_name', $aComment))
		{
			$this->aValidationErrors['cm_name'] = 'name-required';
			$bValid = false;
		}
		
		if((array_key_exists('cm_email', $aComment) && empty($aComment['cm_email'])) or !array_key_exists('cm_email', $aComment))
		{
			$this->aValidationErrors['cm_email'] = 'email-required';
			$bValid = false;
		}
			
		if((array_key_exists('cm_text', $aComment) && empty($aComment['cm_text'])) or !array_key_exists('cm_text', $aComment))
		{
			$this->aValidationErrors['cm_text'] = 'comment-text-required';
			$bValid = false;
		}
		
		if((array_key_exists('ct_id', $aComment) && empty($aComment['ct_id'])) or !array_key_exists('ct_id', $aComment))
		{
			$this->aValidationErrors['ct_id'] = 'content-type-required';
			$bValid = false;
		}
		
		if((array_key_exists('id', $aComment) && empty($aComment['id'])) or !array_key_exists('id', $aComment))
		{
			$this->aValidationErrors['id'] = 'item-id-required';
			$bValid = false;
		}
		
		/*if(empty($aComment['cm_datetime']))
		{
			$this->aValidationErrors['id'] = 'Item Id is requied';
			$bValid = false;
		}*/
		
		return $bValid;
	}
	
	public function getValidationErrors()
	{
		return $this->aValidationErrors;
	}
	
	public function createComment($aComment = array())
	{
		$oIpAddress = new Model_Ipaddress;
		
		if(!array_key_exists('cm_fk', $aComment))
			$aComment['cm_fk'] = '0';
			
		if(!array_key_exists('cm_username', $aComment))
			$aComment['cm_username'] = '';
		
		if(!array_key_exists('cm_title', $aComment))
			$aComment['cm_title'] = '';
			
		if(!array_key_exists('cm_active', $aComment))
			$aComment['cm_active'] = '0';
			
		if(!array_key_exists('cm_deleted', $aComment))
			$aComment['cm_deleted'] = '0';		
			
		$aComment['cm_datetime'] = date('Y-m-d H:i:s');
		$aComment['cm_ip'] = $oIpAddress->getIpAddressId(Request::$client_ip);		
		
		$aComment['cm_text'] = $this->parseCommentText($aComment['cm_text']);
		
		return $this->oDbModel->insertComment($aComment);
	}
	
	private function parseCommentText($sText = '')
	{
		$sComment = (str_replace(array('<pre>', '</pre>'), '', $sText));
		
		$aCodeMatches = array();
		
		if(preg_match_all('/<code.+?>.+?<\/code>/s', $sComment, $aCodeMatches))
		{
			require Kohana::find_file('vendor', 'geshi/src/geshi', 'php');
			
			$aCodeMatches = $aCodeMatches[0];
			
			foreach($aCodeMatches as $sCodeNode)
			{
				$aMathes = array();
				
				if(preg_match_all('/(<code\sclass\=\"(.*)\".*>)(.*)(<\/code>)/s', ($sCodeNode), $aMathes, PREG_SET_ORDER))
				{
					$aMathes = $aMathes[0];
					
					$geshi = new GeSHi($aMathes[3], str_replace('language-', '', $aMathes[2]));
					
					$sComment = str_replace($aMathes[0],  $geshi->parse_code(), $sComment);
				}
			}
		}
		
		return ($sComment);
	}
	
	public function addSubscribtion($sEmail, $iCtId, $iItemId, $sName)
	{
		return $this->oDbModel->insertSubscribtion($sEmail, $iCtId, $iItemId, $sName);
	}
	
	public function getSubscribed($iItemType, $iItemId)
	{
		return $this->oDbModel->getSubscribed($iItemType, $iItemId);
	}
	
	public function notifyAdmin($aData = array(), $sLangCode = 'ru')
	{
		if(array_key_exists('title', $aData))
			$sTitle = $aData['title'];
		else
			$sTitle = '';	
		
		return Email::factory(
			'Новый комментарий: "'.$sTitle.'"', 
			View::factory(
				$this->path->view_module.'comment/new_comment_admin_notify_'.$sLangCode, array(
					'username' => $aData['username'],
					'comment' => $aData['comment'],
					'link' => '<a href="'.$aData['url'].'" target="_blank">'.$sTitle.'</a>'
				))->render(),
			'text/html')
    ->to('kolombetam@uawebs.net')
    ->from('kolombetam@uawebs.net', 'BLOG ADMIN - Артём Коломбет')
    ->send();
	}
	
	public function notifyUser($aData = array(), $sLangCode = 'ru')
	{
		if(array_key_exists('title', $aData))
			$sTitle = $aData['title'];
		else
			$sTitle = '';	
		
		return Email::factory(
			'UA Web Studio - Blogs - Новый комментарий: "'.$sTitle.'"', 
			View::factory(
				$this->path->view_module.'comment/new_comment_user_notify_'.$sLangCode, array(
					'username' => $aData['username'],
					'link' => '<a href="'.$aData['url'].'" target="_blank">'.$sTitle.'</a>'
				))->render(), 'text/html')
    ->to($aData['email'], $aData['username'])
    ->from('kolombetam@uawebs.net', 'Артём Коломбет')
    ->send();
	}
	
	public function notifyUsers()
	{
		$aComments = $this->oDbModel->getCommentsForNotification();
		$oConfig = (object) Kohana::$config->load('comment_subscription');
		
		$oArticleModel = new Model_Article;
		
		foreach($aComments as $c)
		{
			$aSubs = $this->getSubscribed($c->ct_id, $c->item_id);
			
			foreach($aSubs as $s)
				if(!empty($s->cs_email) && !empty($s->cs_name) && intval($s->ct_id) > 0 && intval($s->item_id) > 0)
					if(!$oConfig->send_only_test or ($oConfig->send_only_test && in_array($s->cs_email, $oConfig->send_only)))
					{
						$oArticle = $oArticleModel->getArticle($s->item_id);
						
						$this->notifyUser(array(
							'title' => $oArticle->title, 
							'username' => $s->cs_name,
							'email' => $s->cs_email,
							'url' => URL::site(
								Route::get('article')->uri(array(
										'id' => $s->item_id
									)) , true
								)
							));
							
						$this->setAsNotified($s->ct_id, $s->item_id);	
					}
		}
	}
	
	public function setAsNotified($iItemType, $iItemId) { return $this->oDbModel->setAsNotified($iItemType, $iItemId); }
}