<?php
  require_once 'gSuggest.php';

  /*
   * Usage example for the gSuggest class.
   * The german Google will we searched for the keyword "javacoffee"
   */
  try {
    $data = gSuggest::getSuggestData('de', 'javacoffee');
    foreach($data as $i => $keyword) {
      echo "Keyword ($i): $keyword\n";
    }
  } catch(Exception $e) {
    printf("Error: %s\n", $e->getMessage());
  }
