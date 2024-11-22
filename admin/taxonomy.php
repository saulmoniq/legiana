<?php 
//create a new meta data, it draws the id of the taxonomy, checks if it has something first, if not turns the bool in an array
function add_new_meta_tax($tax){
    $idTax = $tax->term_id;
    $tax_meta = get_option("esCAT_$idTax");
    if (($tax_meta === false) || ($tax_meta == 0)){
        $tax_meta = array('esCAT' => "");
    } else {
    }
?> 
<!-- Create the form form-field -->
<?php foreach($tax_meta as $value){;?>
<tr class ="form-field">
    <th scope = "row" valign ="top">
        <label for="esCAT" > 
        <?php
            _e('WordPress User ID'); 
        ?>
        </label>
        </th>
        <td> 
        <input type="text" name="tax_meta[esCAT]" id="tax_meta[esCAT]" size="25" style="width:60%;" value="<?php echo esc_attr($value); ?>"><br />
        <span class="description"><?php _e('Categoría en español'); ?></span>
        </td> <?php }
}      

function add_new_meta_tax_v2($tax){
    $idTax = $tax->term_id;
    $tax_meta = get_option("OgCat_$idTax");
    if (($tax_meta === false) || ($tax_meta == 0)){
        $tax_meta = array('OgCat' => "");
    } else {
    }
?> 
<!-- Create the form form-field -->
<?php foreach($tax_meta as $value){;?>
<tr class ="form-field">
    <th scope = "row" valign ="top">
        <label for="OgCat_" > 
        <?php
            _e('original category'); 
        ?>
        </label>
        </th>
        <td> 
        <input type="text" name="tax_meta[OgCat]" id="tax_meta[OgCat]" size="25" style="width:60%;" value="<?php echo esc_attr($value); ?>"><br />
        <span class="description"><?php _e('Categoría en español'); ?></span>
        </td> <?php }
} 

//saves the info inside the database to persist
    function save_new_meta_tax($term_id){
        //check if a post has been submitted to the field
        if ( isset( $_POST['tax_meta'] ) ) {
            $idTax = $term_id;
            //retrieves the id for the tax to modify
            $tax_meta = get_option("esCAT_$idTax");
            $cat_keys = array_keys( $_POST['tax_meta'] );
            //run inside every key for the array checking the proper name
                foreach ( $cat_keys as $key ){
                if ( isset( $_POST['tax_meta'][$key] ) ){
                    // assign the value to the key
                    $tax_meta[$key] = $_POST['tax_meta'][$key];
                }
            }
            //save the option array
            update_option( "esCAT_$idTax", $tax_meta );
        }

    }
