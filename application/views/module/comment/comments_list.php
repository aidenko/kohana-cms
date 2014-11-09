<?php if(isset($sPagination)) {?>
	<div class="comments pagination">
		<?=$sPagination?>
	</div>
<?php } ?>

<ul class="comments">
<?php foreach($aComments as $c) { ?>
<li class="comment" data-commentid="<?=$c->cm_id?>">
	<div class="header">
		<div class="title">#<?=$c->cm_id?>&nbsp;</div>
		<div class="name"><?=$c->cm_name?></div>
		<div class="votes"><span class="plus">+<?=isset($c->plus) ? $c->plus : 0 ?></span> / <span class="minus">-<?=isset($c->minus) ? $c->minus : 0?></span>&nbsp;</div>
		<div class="datetime"><?=$c->cm_datetime?>&nbsp;|&nbsp;</div>
        <div class="answer"><a href="javascript:void(0);" onclick="oComment.quote('<?=$c->cm_id?>');" rel="nofollow"><?=I18n::get('comment-answer', $lang)?></a>&nbsp;|&nbsp;</div>
		<div style="clear: both;"></div>
	</div>
	
	<div class="text">
		<?=$c->cm_text?>
	</div>
</li>
<?php } ?>
</ul>

<?php if(isset($sPagination)) {?>
	<div class="comments pagination">
		<?=$sPagination?>
	</div>
<?php } ?>