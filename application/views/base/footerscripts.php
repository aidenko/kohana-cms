<div class="footer-scripts">
<?php

foreach($script as $sc)
	if(array_key_exists('path', $sc))
		//echo HTML::script($sc['path']).PHP_EOL;
		echo '<script src="'.$sc['path'].'"></script>'.PHP_EOL; 
	elseif(array_key_exists('body', $sc))
		echo '<script>'.$sc['body'].'</script>'.PHP_EOL;
		
?>
</div>		