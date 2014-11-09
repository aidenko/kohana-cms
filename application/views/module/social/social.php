<ul class="social">
	
	<?php if($cfg->show && $cfg->gp['show']) { ?>
	<li class="button">
		<div class="g-plusone" data-size="medium" data-href="<?=$url?>"></div>
	</li>
	<?php } ?>
	
	<?php if($cfg->show && $cfg->fb['show']) { ?>
	<li class="button">
		<div id="fb-root"></div>
		<div class="fb-like" data-href="<?=$url?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	</li>
	<?php } ?>
	
	<?php if($cfg->show && $cfg->vk['show']) { ?>
	<li class="button">
		<div id="vk_like"></div>
	</li>
	<?php } ?>
	
	<?php if($cfg->show && $cfg->tw['show']) { ?>
	<li class="button">
		<a href="https://twitter.com/kolombetam" class="twitter-share-button" data-via="kolombetam" data-url="<?=$url?>" data-counturl=<?=$url?> data-lang="ru">Tweet</a>
	</li>
	<?php } ?>
	
	<li style="clear: both;"></li>
</ul>



<br />