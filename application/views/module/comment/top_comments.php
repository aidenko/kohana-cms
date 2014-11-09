<div class="comments most-recent">
	<?=strtr(I18n::get('the-most-recent', $lang), array(':total' => ($iTotal > 10 ? 10 : $iTotal)))?>
</div>

<?php if(isset($iTotal) && $iTotal > 0) { ?>
	<div class="comments total">
		<a class="view-all" href="/<?=$sAllUrl?>"><?=I18n::get('view-all-article-comments', $lang)?> (<?=$iTotal?>)</a>
	</div>
<?php } ?>

<div style="clear: both;"></div>
<br />

<?=(isset($sComments) && !empty($sComments)) ? $sComments : '';?>

<?php if(isset($iTotal) && $iTotal > 0) { ?>
	<div class="comments total">
		<a class="view-all" href="/<?=$sAllUrl?>"><?=I18n::get('view-all-article-comments', $lang)?> (<?=$iTotal?>)</a>
	</div>
	
	<div style="clear: both;"></div>
<?php } ?>