<?php
/*
 * Layout options
 */

$config = array(
	'id'       => 'vh_layouts',
	'title'    => esc_html__('Layouts', 'whitelab'),
	'pages'    => array('page', 'post'),
	'context'  => 'normal',
	'priority' => 'high',
);

$options = array(array(
	'name'    => esc_html__('Layout type', 'whitelab'),
	'id'      => 'layouts',
	'type'    => 'layouts',
	'only'    => 'page,post',
	'default' => get_option('default-layout'),
));

require_once(get_template_directory() . '/functions/admin/metaboxes/add_metaboxes.php');
new create_meta_boxes($config, $options);