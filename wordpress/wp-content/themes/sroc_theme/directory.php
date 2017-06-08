<?php
// ADDING CUSTOM POST TYPE
add_action('init', 'all_custom_post_types');
function all_custom_post_types() {
  $types = array(
    array('the_type' => 'directory',
    'single' => 'Directory',
    'plural' => 'Directories'));
  
  foreach ($types as $type) {
  
  $the_type = $type['the_type'];
  $single = $type['single'];
  $plural = $type['plural'];
  $labels = array(
  'name' => _x($plural, 'post type general name'),
  'singular_name' => _x($single, 'post type singular name'),
  'add_new' => _x('Add New', $single),
  'add_new_item' => __('Add New '. $single),
  'edit_item' => __('Edit '.$single),
  'new_item' => __('New '.$single),
  'view_item' => __('View '.$single),
  'search_items' => __('Search '.$plural),
  'not_found' => __('No '.$plural.' found'),
  'not_found_in_trash' => __('No '.$plural.' found in Trash'),
  'parent_item_colon' => ''
  );
  $args = array(
  'labels'             => $labels,
  'public'             => true,
  'has_archive'        => true,
  'publicly_queryable' => true,
  'show_ui'            => true,
  'query_var'          => true,
  'rewrite'            => true,
  'capability_type'    => 'post',
  'hierarchical'       => false,
  'menu_position'      => 5,
  'supports'           => array('title','editor','thumbnail','custom-fields','excerpt'));
register_post_type($the_type, $args);
  }
}
?>
