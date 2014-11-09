<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$lang?>" lang="<?=$lang?>">
	<head>
		<?=View::factory('base/head', is_array($aHead) ? $aHead : array())?>
	</head>
	<body>
		<socket:header=block/header />
		
		<socket:main=block/main />
		
		<?//=$body?>
		
		<socket:footer=block/footer />
		
		INDEX
	</body>
</html>


