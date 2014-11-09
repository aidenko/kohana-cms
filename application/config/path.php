<?php defined('SYSPATH') OR die('No direct access allowed.');

$a = array();

$a['assets'] = '/assets/';
$a['css'] = $a['assets'].'css/';
$a['css_cache'] = $a['css'].'cache/';
$a['img'] = $a['assets'].'img/';
$a['js'] = $a['assets'].'js/';
$a['js_cache'] = $a['js'].'cache/';
$a['media'] = $a['assets'].'media/';
$a['jquery'] = $a['assets'].'jquery/'; 
$a['css_template'] = $a['css'].'template/';
$a['css_admin'] = $a['css'].'admin/';
$a['ck_editor'] = $a['assets'].'ckeditor/';

$a['views'] = '';
$a['view_template'] = $a['views'].'template/';
$a['view_module'] = $a['views'].'module/';
$a['view_admin'] = $a['views'].'admin/';

$a['controller'] = 'Controller/';

$a['controller_template'] = $a['controller'].'Template/';
$a['controller_module'] = $a['controller'].'Module/';
$a['controller_system'] = $a['controller'].'System/';
$a['controller_admin'] = $a['controller'].'Admin/';
$a['controller_action'] = $a['controller'].'Action/';

return $a;

?>
