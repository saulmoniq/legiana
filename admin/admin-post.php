<?php
function your_update_function() {
  


  // Get the submitted value from the form
  ?><br> <?php
  $idTax = $_POST['termid'];
  $termName[0] = $_POST['termname'];
  $tax_meta = get_option("esCAT_$idTax");
  $updated_value = array_keys( $_POST['tax_meta'] );
  $filter = $_POST['filter'];

  // Get the current term ID (assuming you have access to it)
  $taxonomy = 'product_cat';
  $terms = get_terms( $taxonomy, array (
    'hide_empty' => false,
    'hierarchical' => true,
    'fields' => 'all', 
    ) );
  
  
  // storing the og name from the Cat
//logic to access the parents or childrens of the category
function get_top_parent_recursive( $term_id, $taxonomy ) {
  // Check for compatibility with fallback
  if ( function_exists('wp_get_term_parent') ) {
      $parent_id = wp_get_term_parent( $term_id, $taxonomy );
  } else {
      // If wp_get_term_parent is unavailable, use get_term
      $parent = get_term( $term_id, $taxonomy );
      $parent_id = $parent->parent;
  }

  if ( $parent_id ) {
    return get_top_parent_recursive( $parent_id, $taxonomy );
  } else {
    return $term_id; // Term has no parent (category 1)
  }
}
foreach ( $terms as $term ) {
  if($term->term_id == $idTax){
    if ($term->parent == 0){
      $originalCat = [$term->name];}
      else  {
        $parent_id = $term->parent; // ID del término padre
        $parent_term = get_term( $parent_id, $taxonomy );
        $parent_name = $parent_term->name;  
        $custom_meta_key = get_option("ogCAT_$parent_id");
        $top_parent_id = get_top_parent_recursive( $parent_id, $taxonomy );
        $top_parent_term = get_term( $top_parent_id, $taxonomy );
        $grandparent_custom_meta_key = get_option("ogCAT_$top_parent_id");
        if(empty($custom_meta_key) && empty($grandparent_custom_meta_key)){
        if ( $top_parent_term->name != $parent_name) {
          $originalCat = [$top_parent_term->name . " > " . $parent_name . " > " . $term->name];
        } else {
        $originalCat = [$parent_name . " > " . $term->name];
        }} else{
          // tengo que crear la condicion para que solo ponga uno o los dos si aplica.
          if ( $grandparent_custom_meta_key[0] != $custom_meta_key[0]) {
            if(empty($custom_meta_key[0])){
              $originalCat =[$grandparent_custom_meta_key[0] . " > " . $parent_name . " > " . $term->name];
            }
            else {
            $originalString = $custom_meta_key[0]; // "split the parent value to take only one"
            $splitArray = explode(">", $originalString);
            $parent_nameOG = $splitArray[1];
          $originalCat =[$grandparent_custom_meta_key[0] . " > " . $parent_nameOG . " > " . $term->name];
        }
        } else {
          $originalCat =[$custom_meta_key[0] . " > " . $term->name];
        }

        }
      // Retrieve and display the esCAT meta value safely
}}}
  if ($filter == 1){
    update_option( "OgCat_$idTax", $originalCat );
  }
  else{  }



    // Here start to process the info from the form to change name and slug
      foreach ( $updated_value as $key ){
        if ( isset( $_POST['tax_meta'][$key] ) ){
            // assign the value to the key
            $tax_meta[$key] = $_POST['tax_meta'][$key];
            $args = array(
              'name' => $tax_meta[$key],
              'slug' => $tax_meta[$key]// here would go the slug to change
            );
         
        }
    }
    wp_update_term( $idTax, $taxonomy, $args );

    update_option( "esCAT_$idTax", $termName );
    // Redirect to the current page after successful update
    // (adjust URL based on your needs)
    wp_redirect( admin_url('admin.php?page=legiana%2Fadmin%2Fview.php' )); 
    exit; 
    }
  //add_action( 'product_cat_edit_form_fields', 'add_new_meta_tax', 10, 2 );
