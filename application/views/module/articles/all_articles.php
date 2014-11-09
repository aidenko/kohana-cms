<div class="module module-articles">
	<div class="title"><?=I18n::get('all-articles', $lang)?></div>
	<div class="content">
		<ul>
		 <?php foreach($aArticles as $a) { ?>
		 	
		 	<li class="article">
			 <a href="/<?=Route::get('article')->uri(array('id' => $a->id))?>"><?=$a->title?></a>
		 	</li>
		 	
		 <?php } ?>
	 </ul>
	</div>
</div>