<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
  'default' => array(
      'current_page'      => array('source' => 'route', 'key' => 'page'), // source: "query_string" or "route"
      'total_items'       => 0,
      'items_per_page'    => 10,
      'view'              => 'pagination/floating',
      'auto_hide'         => TRUE,
      'first_page_in_url' => FALSE,
  ),
);