<?php
/**
 * Controller_Module_Social
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-05-23		Artem Kolombet		[1.0]					created
 */
class Controller_Module_Social extends Controller_System_Module
{
	public function action_index()
	{
		$social = (object) Kohana::$config->load('social');
		
		if($social->show)
			$this->setBody(View::factory($this->path->view_module.'social/social', array('cfg' => $social, 'url' => URL::base(true, true).Request::detect_uri())));
	}
	
	public function getScripts()
	{
		$social = (object) Kohana::$config->load('social');
		
		$aScripts = array();
		
		if($social->show)
		{
			if($social->fb['show'])
				$aScripts[] = array(
				
					'body' => 
						"(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = \"//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=".$social->fb['appid']."&version=v2.0\";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));",
						
					'order' => 3,
					'target' => 'footer'
					);
			
			if($social->vk['show'])
			{
				$aScripts[] = array(
					'path' => 
						"//vk.com/js/api/openapi.js?113",
					'order' => 4,
					'target' => 'footer'
				);
				
				$aScripts[] = array(
					'body' => 
						"VK.init({apiId: ".$social->vk['appid'].", onlyWidgets: true});",
					
					'order' => 5,
					'target' => 'footer'	
				);
				
				$aScripts[] = array(
					'body' => 
						'VK.Widgets.Like("vk_like", {type: "mini"});',
					
					'order' => 6,
					'target' => 'footer'	
				);
			}
			
			if($social->gp['show'])	
				$aScripts[] = array(
					'body' => 
						"window.___gcfg = {lang: 'ru'};

					  (function() {
					    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					    po.src = 'https://apis.google.com/js/platform.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();",
					  
					 'order' => 6,
					 'target' => 'footer' 
				);
				
			if($social->tw['show'])	
				$aScripts[] = array(
					'body' => 
						'!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");',
					  
					 'order' => 6,
					 'target' => 'footer'
				);			
					
		}
		
		return $aScripts;
	} 
	
	public function getStyles()
	{
		$social = (object) Kohana::$config->load('social');
		
		$aStyles = array();
		
		if($social->show&& ($social->fb['show'] or $social->vk['show']))
			$aStyles[] = array('path' => $this->path->css.'module-social.css', 'order' => 3);
			
		return $aStyles;	 
	}
}	