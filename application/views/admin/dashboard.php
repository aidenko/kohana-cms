<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$lang?>" lang="<?=$lang?>">
	<head>
		<?=View::factory('base/head', is_array($aHead) ? $aHead : array())?>
	</head>
	<body>
		<div class="wrapper">
			<?/*<socket name="header" controller="template/main/block/header" />*/?>
			<div class="left-column"></div>
			<div class="center">
			
				<?=isset($body) ? $body : ''?>
				
			</div>
			<div class="right-column">

			</div>
			
			<div style="clear: both;"></div>
			
			<br />
			<?/*<socket name="footer" controller="template/main/block/footer" />*/?>
		</div>
	</body>
</html>