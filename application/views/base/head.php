<title><?=$title?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<?php 

foreach($meta as $name => $content)
	if(!empty($content))
		echo '<meta name="'.$name.'" content="'.$content.'" />'."\n";

foreach($style as $st)
	echo HTML::style($st['path']).PHP_EOL;
	
foreach($script as $sc)
	if(array_key_exists('path', $sc))
		//echo HTML::script($sc['path']).PHP_EOL;
		echo '<script src="'.$sc['path'].'"></script>'.PHP_EOL; 
	elseif(array_key_exists('body', $sc))
		echo '<script>'.$sc['body'].'</script>'.PHP_EOL;
				