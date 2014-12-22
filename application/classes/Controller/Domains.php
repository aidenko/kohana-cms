<?php
/**
 * Controller_Domains
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-08-29		Artem Kolombet		[1.0]					created
 */
class Controller_Domains extends Controller_System_Component
{
	public function before()
	{
		$this->setTemplateFile('domains');
		
		parent::before();
	}
	
	public function action_update_domains()
	{	
		$this->oConfig = (object) Kohana::$config->load('sell_domains');
		
		$aMatch = array();
		
		preg_match('/.*\<body.*?\>(.*)\<\/body\>.*/s', iconv("Windows-1251//IGNORE", "UTF-8//IGNORE", file_get_contents($this->oConfig['url'])), $aMatch);
		
		$aPatterns = array(
			'/.?[\b\w\-]+\=[\"\'].+?[\"\'](?=\s|\>)/'
		);
		
		$sMonetaryPatttern = '/[\D\s]*$/';

		preg_match_all('/.*?(\<table.*?class\=\"tariffpartner\".*?\>.*?\<\/table\>).*?/s', $aMatch[1], $aMatch);
		
		$aPrices = array('domain' => array(), 'hosting' => array());
		
		preg_match_all('/.*?\<tr\>(.*?)\<\/tr\>.*?/s', preg_replace($aPatterns, "", $aMatch[1][1]), $aDomainsMatch);
		
		$oDomain = new Model_Domains;
		
		$aDomainsMatch = array();
		$aHostingMatch = array();
		
		preg_match_all('/.*?\<tr\>(.*?)\<\/tr\>.*?/s', preg_replace($aPatterns, "", $aMatch[1][1]), $aDomainsMatch);
				
		foreach($aDomainsMatch[1] as $k => $tr)
		{
			if($k > 1)
			{
				$aDomain = array();
				
				preg_match_all('/\<td\s?\>(.*?)\<\/td\>/', $tr, $aDomain);

				$aDomain = $aDomain[1];
				
				if(count($aDomain) == 6)
					$aPrices['domain'][$aDomain[0]] = array(
						'retail' => preg_replace($sMonetaryPatttern, '', strip_tags($aDomain[1])),
						'bronse' => preg_replace($sMonetaryPatttern, '', strip_tags($aDomain[2])),
						'silver' => preg_replace($sMonetaryPatttern, '', strip_tags($aDomain[3])),
						'gold' => preg_replace($sMonetaryPatttern, '', strip_tags($aDomain[4])),
						'platinum' => preg_replace($sMonetaryPatttern, '', strip_tags($aDomain[5]))
					);
			}
		}
		
		preg_match_all('/.*?\<tr\>(.*?)\<\/tr\>.*?/s', preg_replace($aPatterns, "", $aMatch[1][2]), $aHostingMatch);
				
		foreach($aHostingMatch[1] as $k => $tr)
		{
			if($k > 1)
			{
				$aHosting = array();
				
				preg_match_all('/\<td\s?\>(.*?)\<\/td\>/', $tr, $aHosting);
				
				$aHosting = $aHosting[1];
				
				if(count($aHosting) == 6)
				{
					for($i = 1; $i <= 5; $i++)
					{
						preg_match_all('/\<span\s?\>(.*?)\<\/span\>/', $aHosting[$i], $aHostingPrices);
					
						if($i == 1)
							$sPriceType = 'retail';
						elseif($i == 2)	
							$sPriceType = 'bronse';
						elseif($i == 3)	
							$sPriceType = 'silver';
						elseif($i == 4)	
							$sPriceType = 'gold';
						elseif($i == 5)	
							$sPriceType = 'platinum';
									
						if(!empty($sPriceType))
							$aPrices['hosting'][$aHosting[0]][$sPriceType] = preg_replace($sMonetaryPatttern, '', strip_tags($aHostingPrices[1][1]));
					}		
				}
			}
		}

		foreach($aPrices['domain'] as $name => $prices)
			$oDomain->addDomain($name, $prices);
			
		foreach($aPrices['hosting'] as $name => $prices)
			$oDomain->addDomain($name, $prices, true, true);

	}
	
	public function action_index()
	{	
		$oMetaData = new Model_Metadata;
		$oDomain = new Model_Domains;

		$this->setTitle($oMetaData->getTitle($this->request->controller(), 2));
		
		$this->setMetaKeywords($oMetaData->getKeywords($this->request->controller(), 2));
		$this->setMetaDescription($oMetaData->getDescription($this->request->controller(), 2));
		
		$this->addStyle($this->path->css.'domains.css', 2);
		$this->addScript('//ajax.googleapis.com/ajax/libs/angularjs/1.2.27/angular.min.js', 1, 'footer');
		$this->addScript('//ajax.googleapis.com/ajax/libs/angularjs/1.2.27/angular-route.js', 2, 'footer');
		$this->addScript($this->path->js.'domains/domains.js', 3, 'footer');
		//$this->addScript($this->path->js.'domains-search.js', 4);
		$this->addScript($this->path->js.'domains/domains-list.js', 5, 'footer');
		$this->addScript($this->path->js.'domains/domains-check.js', 6, 'footer');

	}
}	
