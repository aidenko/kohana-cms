<?php if($sSearchHtml && !empty($sSearchHtml))
echo $sSearchHtml
?>

<div class="domains-list">

<?php if(is_array($aDomains) && count($aDomains) > 0)
{
	foreach($aDomains as $domain) { ?>
		
		<div class="domain">
			
			<span class="domain-attribute name"><?=$domain->sdo_name?></span>

			<?=isset($domain->prices) && is_array($domain->prices) ? implode(" ", $domain->prices) : ''?>

		</div>
		
	<?php }	
} ?>
</div>
