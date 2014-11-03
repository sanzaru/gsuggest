<?php
  define('SUGGEST_URL', 'http://clients1.google.com/complete/search?hl=@COUNTRY@&output=xml&q=@QUERY@');

  /**
   * Simple class to fetch suggestion data from google.
   * This could be used for keyword research.
   *
   * @author Martin Albrecht <martin.albrecht@javacoffee.de>
   */
  class gSuggest {
    /**
     * Fetch the suggestion data
     * @param string $lang The language identifier (e.g. en, de)
     * @param string $query The query string
     * @throws Exception
     */
    public static function getSuggestData($lang=null, $query=null) {
      // Check parameters
      if( $lang === null || $query === null ) {
        throw new Exception('Required parameters not set');
      }

      // Create query url
      $queryUrl = str_replace(array('@COUNTRY@', '@QUERY@'),
                              array($lang, $query), SUGGEST_URL);
      // Fetch XML from google
      $suggestFeed = file_get_contents($queryUrl);
      if( $suggestFeed === false ) {
        throw new Exception('Cannot load data from query URL');
      }

      // Load XML data into object
      $xmlData = simplexml_load_string(utf8_encode($suggestFeed));
      if( $xmlData === false ) {
        throw new Exception('Cannot load XML data');
      }

      // Process the XML object
      $returnData = array();
      if( !empty($xmlData) && !empty($xmlData->CompleteSuggestion) ) {
        foreach($xmlData->CompleteSuggestion as $element) {
          $s_data = $element->suggestion->attributes();
          $returnData[] = (string) $s_data['data'];
        }
      }
      return $returnData;
    }
  };

