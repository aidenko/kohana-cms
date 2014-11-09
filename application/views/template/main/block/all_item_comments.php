<?php if(isset($sItemPreview) && !empty($sItemPreview)) { ?>
	<div class="comments view-all-comments">
		<article>
			<?php if(isset($sPreviewTitle) && !empty($sPreviewTitle)) { ?>
			<h1 class="comments item-title"><a href="/<?=$sBackLink?>"><?=$sPreviewTitle?></a></h1>&nbsp;<a class="comments back-link" href="/<?=$sBackLink?>">&larr;&nbsp;<?=I18n::get('back-to-article', $lang)?></a>
			<?php } ?>
			<br />
			<br />
			<div class="article-content">
			<?=$sItemPreview?> ...
			</div>
		</article>
	</div>
<?php } ?>

<?=(isset($sComments) && !empty($sComments)) ? $sComments : '';?>
<br />
<a class="comments back-link right" href="/<?=$sBackLink?>">&larr;&nbsp;<?=I18n::get('back-to-article', $lang)?></a>
<div style="both"></div>
<br />
<br />
