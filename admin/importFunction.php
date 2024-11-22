<? 

function getCategoryHeirarchyUpdate($filePathUser,$filePathEs, $payloadCategory) {
  // Read the JSON data from the file
  $findme = "|";
  $jsonString = file_get_contents($filePathEs);
  $jsonStringUser = file_get_contents($filePathUser);

  if ($jsonString === false || $jsonStringUser === false ) {
      // Handle file reading error
      return "Error reading JSON file";
  }

  // Convert JSON to PHP array
  $categoriesData = json_decode($jsonString, true);
  $categoriesDataUser = json_decode($jsonStringUser, true);

  if ($categoriesData === null && json_last_error() !== JSON_ERROR_NONE) {
      // Handle JSON decoding error
      return "Error decoding JSON: " . json_last_error_msg();
  }
  $findExplode = strpos($payloadCategory, $findme);
    if ($findExplode == false){
      foreach ($categoriesData as $category) {
        //Encuentra si el PT es igual al ES
            if ($category['category_heirarchy'] == $payloadCategory) {
                //Si es igual, pasa a buscar si el ES es igual a la cat original.
                foreach ($categoriesDataUser as $catUser){
                if ($category['category_heirarchy_es'] == $catUser['catOriginal'] ){
                    //Si es igual, retorna la categoria con el nombre del usuario (u original)
                    return $catUser['nombreDeUsuario'];
                } // Si no es igual, retorna el nombre de usuario
                 else {return $category['category_heirarchy_es'];} 
                }
            } 
        }
    } else {
      $categoryArray = explode(" | ", $payloadCategory);
      $one = $categoryArray[0];
      $two = $categoryArray[1];
        // Search for the matching category
        foreach ($categoriesData as $category) {
        //echo $category['category_heirarchy'] . ' ?= ' . $payloadCategory . '<br>';
            if ($category['category_heirarchy'] == $one) {
                // Return the corresponding category_heirarchy_es
                foreach ($categoriesDataUser as $catUser){
                    if ($category['category_heirarchy_es'] == $catUser['catOriginal'] ){
                        //Si es igual, retorna la categoria con el nombre del usuario (u original)
                        $esOne = $catUser['nombreDeUsuario'];
                    } else {$esOne = $catUser['nombreDeUsuario'];}                 
            }} if($category['category_heirarchy'] == $two){
                foreach ($categoriesDataUser as $catUser){
                    if ($category['category_heirarchy_es'] == $catUser['catOriginal'] ){
                        //Si es igual, retorna la categoria con el nombre del usuario (u original)
                        $esTwo = $catUser['nombreDeUsuario'];
                    } else {$esOne = $catUser['nombreDeUsuario'];}                   
            }
            
      }}
      echo $esOne.$findme.$esTwo;
      return null;
    }


  // Return null if no matching category is found
  return $payloadCategory;
}

// Caller: [getCategoryHeirarchyUpdate("https://ams1.vultrobjects.com/investtechcanarion360/2024/04/fielUSer-1.json","https://imagenes.bighub.es/wp-content/uploads/2024/01/convert_categories_pt_es.json",{category_heirarchy[1]})]