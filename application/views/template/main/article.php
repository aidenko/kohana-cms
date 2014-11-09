<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$lang?>" lang="<?=$lang?>">
	<head>
		<?=View::factory('base/head', is_array($aHead) ? $aHead : array())?>
	</head>
	<body>
		<div class="wrapper">
			<socket name="header" controller="template/main/block/header" />
			<div class="left-column"></div>
			<div class="center">
			
				<?=isset($body) ? $body : ''?>
				
				<socket name="adv3" controller="template/main/block/adv3" />
				<br />
				<socket name="social" controller="module/social" />
				<br />
				<socket name="comment" controller="module/comment" method="post_form" param="/1/{id}" />
				<br />
				<socket name="comment" controller="module/comment" method="item_comment" param="/1/{id}" />
				<br />
				<br />
				<socket name="adv2" controller="template/main/block/adv2" />
				<br />
				<socket name="adv5" controller="template/main/block/adv5" />
			</div>
			<div class="right-column">
				<socket name="adv1" controller="template/main/block/adv1" />
				<br />
				<socket name="articles" controller="module/articles" method="get_all_articles" />
			</div>
			
			<div style="clear: both;"></div>
			
			<br />
			<socket name="footer" controller="template/main/block/footer" />
			<?=View::factory('base/footerscripts', is_array($aFooter) ? $aFooter : array())?>
		</div>
	</body>
</html>