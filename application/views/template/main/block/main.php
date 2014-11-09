<div class="articles">
	<ul>
	<?php foreach($aArticles as $i => $article) { ?>
		<li class="<?=($i % 2 == 0 ? 'even' : 'odd')?>" itemscope itemtype="http://schema.org/Article">
			<div class="title"><a href="/<?=Route::get('article')->uri(array('id' => $article->id));?>" itemprop="name"><?=$article->title?></a></div>
			<div class="article-content" itemprop="headline">
				<?=$article->preview_text?>
			</div>
		</li>
	<?php } ?>
	</ul>
</div>

<?php if(isset($sPagination)) {?>
	<div class="pagination">
		<?=$sPagination?>
	</div>
<?php } ?>
