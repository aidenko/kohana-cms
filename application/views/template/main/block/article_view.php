<?php 

if(!is_null($oArticle)) { ?>
	<article itemscope itemtype="http://schema.org/Article" class="protect">
		<h1 itemprop="name"><?=$oArticle->title?></h1>
		<br />
		<br />
		<div class="article-content" itemprop="articleBody">
		<?=$oArticle->text?>
		</div>
	</article>
<?php } ?>