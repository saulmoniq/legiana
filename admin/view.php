<!-- hardcoded this should not be like this -->
<!-- Estilos para el lado admin -->
<link rel="stylesheet" type="text/css" href= "../wp-content/plugins/legiana/css/style.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<?php
ob_start();
// this is to retrieve ancesthor futher ahead
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
//Llamado a la lógica de las categorías y terms.
echo "<br>";
$taxonomy = 'product_cat';
$terms = get_terms( $taxonomy, array (
    'hide_empty' => false,
    'hierarchical' => true,
    'fields' => 'all', 
) );
?>
<!-- Inicio de diseño html -->
<div class = "banner">
  <div class ="banner-text"> 
   <center> <h1 class ="title">Modificar las categorías</h1></center>
    <h2 class = "title">¡Sigue los pasos y modifica tu tienda como mejor lo veas!</h6>
  </div>
</div>

<section class='FlexContainer' name="howTo">
            <center> <div><span class="dashicons dashicons-search iconsize"></span><h2>1. Ubica la categoría a modificar. </h6></div></center>
            <center><div><span class="dashicons dashicons-welcome-write-blog iconsize"></span><h2> 2. Sustituye por el nuevo nombre. </h6></div></center>
            <center><div><span class="dashicons dashicons-external iconsize"></span><h2> 3. Da click en actualizar. </h6></div></center>
        </section>

 <!-- Fin diseño html -->

<?php

// Check if terms exist before proceeding
if ( !empty($terms) ) {
    ?><div class="container">
          <div class="row"><?php
    foreach ( $terms as $term ) {
      ?><div class="col-md-4"><?php  

      if ($term->parent == 0){
        echo '<li class="lista">' . $term->name . '</li>';}
        else  {
          $parent_id = $term->parent; // ID del término padre
          $parent_term = get_term( $parent_id, $taxonomy );
          $parent_name = $parent_term->name;  
          $top_parent_id = get_top_parent_recursive( $parent_id, $taxonomy );
          $top_parent_term = get_term( $top_parent_id, $taxonomy );
          if ( $top_parent_term->name != $parent_name) {
            echo '<li class="lista">' . $term->name . '</li>';
            echo '<h3>' . $top_parent_term->name . " > " . $parent_name . ">" . "<span>" . $term->name . "</span>" . '</h3>';
          } else {
                      echo '<li class="lista">' . $term->name . '</li>';
          echo '<h3>' . $parent_name . ">" . "<span>" . $term->name . "</span>" . '</h3>';}
          }
        // Retrieve and display the esCAT meta value safely
        $idTax = $term->term_id;
        $termName = array(
          'name' => $term->name
        );
        $tax_meta = get_option("esCAT_$idTax");
        if(!empty($tax_meta)){ 
          ?>
          <?php foreach($tax_meta as $value){;?>
        <form action="<?php echo admin_url( 'admin-post.php' ) ; ?>" method="post">
          <input type="hidden" name="action" value="your_update_function_hook">
          <input type="hidden" name="termid" value="<?php echo $idTax; ?>">
          <input type="hidden" name="filter" value="0">
          <input type="hidden" name="originalCat" value="<?php ?>">
          <input type="hidden" name="termname" value="<?php echo $termName['name']; ?>">
          <!-- <label for="tax_meta[esCAT]">Nueva categoría</label> -->
          <input type="text" name="tax_meta[esCAT]" id="tax_meta[esCAT]" value="<?php echo esc_attr($value); ?>">
          <input type="submit" value="Update">
          <!-- <?php wp_nonce_field( 'your_update_action' ); // Add a nonce for security ?> -->
</form>        
<?php  
            }  
    } //redundancia que quiero resolver luego, este if no es necesario el form deberia mostrarse siempre
    else {?>
      <form action="<?php echo admin_url( 'admin-post.php' ) ; ?>" method="post">
      <input type="hidden" name="action" value="your_update_function_hook">
      <input type="hidden" name="termid" value="<?php echo $idTax; ?>">
      <input type="hidden" name="filter" value="1">
      <input type="hidden" name="originalCat" value="<?php ?>">
      <input type="hidden" name="termname" value="<?php echo esc_attr($termName['name']); ?>">
      <!-- <label for="tax_meta[esCAT]">Nueva categoría</label> -->
      <input type="text" name="tax_meta[esCAT]" id="tax_meta[esCAT]" value= <?php esc_attr("Ingresa valor"); ?>>
      <input type="submit" value="Update">
      <!-- <?php wp_nonce_field( 'your_update_action' ); // Add a nonce for security ?> -->
</form>  
<?php

    }?></div> <?php } ?></div> </div><?php 
} else {
      echo 'No terms found in this taxonomy.';
}
