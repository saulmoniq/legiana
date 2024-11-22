<?php 
add_action('admin_init', 'custom_plugin_buffer_start');

function custom_plugin_buffer_start() {
  ob_start();
}
function export_custom_taxonomy_data_json() {
  // Error handling for invalid taxonomy
 

  $taxonomy_slug = 'product_cat';
  $terms = get_terms($taxonomy_slug, array (
      'hide_empty' => false,
      'hierarchical' => true,
      'fields' => 'all', 
  ) );

  // Prepare data to export (you can customize this)
  $export_data = [];
  foreach ($terms as $term) {
    $export_data[] = [
      'catOriginal' => get_option("OgCat_$term->term_id"),
      'nombreDeUsuario' => $term->name,   
    ];
  }

 

   // Capture and discard any previous output
   $content = ob_get_clean();  // This line captures and discards output

  $json_data = json_encode($export_data,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
  // Check if there's unexpected output
  // Set headers for download
  header('Content-Disposition: attachment; filename= export.json');
  header('Content-type: application/json');
  

  echo $json_data;
  exit;
}
export_custom_taxonomy_data_json();