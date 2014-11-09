<?php
/**
 * Controller_Action_Geshi
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-05-12		Artem Kolombet		[1.0]					created
 */
class Controller_Action_Geshi extends Controller_System_Action
{	
	public function action_index()
	{	
		/*if (function_exists('stream_resolve_include_path') && stream_resolve_include_path('geshi/geshi.php') === false) 
			die('<pre class="html">Please install the GeSHi library. Refer to plugins/codesnippetgeshi/README.md for more information.</pre>');*/
		
		require Kohana::find_file('vendor', 'geshi/src/geshi', 'php');
		
		$json_string = file_get_contents('php://input');
		$json_object = json_decode($json_string);
		
		$geshi = new GeSHi($json_object->html, $json_object->lang);
		
		echo $geshi->parse_code();
	}
}	
