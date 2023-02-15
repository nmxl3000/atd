<?php

/*
 * Function list
 * public static function App($url,$country) 
 * public static function getFilenameAndURLForCountry($country)
 * function filterResults($title,$dataArr)
 * public function getContentFromJSONFile($country)
 * public function getContentFromJSONFile($country)
 * public function getContentFromURL($country)
 * public function showSearchForm($passedTitle)
 * public function showResultsTable($matchedResultsArray) 
 * 
 */

class SearchComponent {
    private $url;
    private $country;
    private $jsonFilename;
    
    function __construct($country) {  
        $this->country=$country;
        $filenameAndUrlArr=SearchComponent::getFilenameAndURLForCountry($country); 
        $this->url=$filenameAndUrlArr['url'];
        $this->jsonFilename=$filenameAndUrlArr['filename'];
    }
    
    // Getters/setters
    function set_url($url) {
      $this->url = $url;
    }

    function get_url() {
      return $this->url;
    }
    
    // Bootstrap method
    public static function App($url,$country) {
        $passedTitle=trim($passedTitle); 
        $passedTitle=preg_replace('/\s+/',' ',$_REQUEST['title']);  
        
        $searchComponentObj = new SearchComponent($url);
        $searchComponentObj->showSearchForm($passedTitle);
        
        if(DEBUG) echo 'URL: ' .$url .'<br />';

        // Only process if a Title is passed
        if(strlen($passedTitle)>0) {
            // Use local data or API call
            if(USE_LOCAL_JSON_FILE_STORE) $contentArray=json_decode($searchComponentObj->getContentFromJSONFile($country),true);
            else $contentArray=$searchComponentObj->getContentFromURL($country);

            if(DEBUG_DATA) {
                echo '<br /><h2>Content returned from URL without filtering</h2><br />';
                print_r($contentArray);
            }
            $matchedResultsArray=$searchComponentObj->filterResults($passedTitle,$contentArray);

            if(DEBUG_DATA) {
                echo '<br /><h2>Content matching passed title</h2><br />';
                print_r($matchedResultsArray);
            }

            if(count($matchedResultsArray)>0) $searchComponentObj->showResultsTable($matchedResultsArray);
            else echo '<div class="no_results">No results found</div>';
        }
    }
    
    public static function getFilenameAndURLForCountry($country) {
      if(DEBUG_METHOD_CALLS) echo "<br />In method: " .__METHOD__ ."<br />";
      
      switch ($country) {
        case 'IRELAND':
            $filename=LOCAL_JSON_IRELAND_FILENAME;
            $url=IRELAND_URL;
            break;
        case 'GERMANY':
            $filename=LOCAL_JSON_GERMANY_FILENAME;
            $url=GERMANY_URL;
            break;
        default: 
            $filename=LOCAL_JSON_ENGLAND_FILENAME;
            $url=ENGLAND_URL;
      }
      
      $retArr = array('filename'=>$filename,'url'=>$url);
      
      return $retArr;
    }
    
    function filterResults($title,$dataArr) {
      if(DEBUG_METHOD_CALLS) echo "<br />In method: " .__METHOD__ ."<br />";
      if(DEBUG) echo '<br />Filtering for title...: ' .$title .'<br />'; 
      
      $numMatches=0;
      $matchedResultsArr=array();
      foreach($dataArr['data'] AS $key=>$data){
          // Using stristr for case insensitive match
          if(stristr(strtolower($data['title']),strtolower($title))) {
            if(DEBUG) echo '<br /><b>Match found: Title: ' .$title .'... Matching string:' .$data['title'] .'</b>';  
            $matchedRowArray=array('title'=>$data['title'],'image'=>$data['img_sml'],'destination'=>$data['dest']);
            if(DEBUG_DATA) print_r($matchedRowArray);
  
            array_push($matchedResultsArr,$matchedRowArray);
            $numMatches++;
          } 
      }
      //echo 'Total matches found: ' .$numMatches .'<br />';
      if(DEBUG) echo 'Total matches found: ' .$numMatches .'<br />';
      if(DEBUG_DATA) print_r($matchedResultsArr);
      
      // Always return an array
      return count($matchedResultsArr)>0 ? $matchedResultsArr: array();
    }
    
    public function getContentFromJSONFile($country) {
      if(DEBUG_METHOD_CALLS) echo "<br />In method: " .__METHOD__ ."<br />";
      
      $filenameUrlArr=SearchComponent::getFilenameAndURLForCountry($country);
      
      $filename=$filenameUrlArr['filename'];
      
      $jsonFileStr= LOCAL_JSON_FILE_PATH .'/' .$filename;
           
      if(DEBUG) echo 'JSON file: ' .$jsonFileStr;
      $jsonFileContentStr = file_get_contents("$jsonFileStr");
      
      if(DEBUG_DATA) echo 'JSON file content: ' .$jsonFileContentStr;
      
      return strlen($jsonFileContentStr)>10 ? $jsonFileContentStr : '{}';
    }
    
    public function getContentFromURL($country) {
      if(DEBUG_METHOD_CALLS) echo "<br />In method: " .__METHOD__ ."<br />";
      
      
      $filenameUrlArr=SearchComponent::getFilenameAndURLForCountry($country);
      
      $url=$filenameUrlArr['url'];
      
      if(DEBUG) echo 'Getting data from endpoint: ' .$url .'<br />';
      
      $curlConn = curl_init();
      curl_setopt($curlConn, CURLOPT_URL,$url);
      curl_setopt($curlConn, CURLOPT_RETURNTRANSFER,true);

      $returnedJSON = curl_exec($curlConn);
      curl_close($curlConn);
      $responseArray = json_decode($returnedJSON,true);
      if(DEBUG_DATA) print_r($responseArray);
      return $responseArray;
    }
    
    public function showSearchForm($passedTitle) {
      if(DEBUG_METHOD_CALLS) echo "<br />In method: " .__METHOD__ ."<br />";
      echo '<div class="search_form"><h2>Product Search</h2>
                <form method="POST" action="/">
                    <label for="title">Title</label>&nbsp;
                    <input type="text" id="title" name="title" value="' .ucfirst($passedTitle) .'">&nbsp;
                    <input type="submit" value="Search">
                </form>
            </div>';
    }
    
    public function showResultsTable($matchedResultsArray) {
        if(DEBUG_METHOD_CALLS) echo "<br />In method: " .__METHOD__ ."<br />";
        echo '<table class="blueTable">
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Destination</th>
            </tr>';
        
            foreach($matchedResultsArray AS $res) {
                echo '<tr>';
                //echo '<td><img src="' .$res['image'] .'" width="30" height="30" /></td>';
                echo '<td><img src="' .$res['image'] .'" /></td>';
                echo '<td>' .$res['title'] .'</td>';
                echo '<td>' .$res['destination'] .'</td>';
                echo '</tr>';
            }        
        echo '</table>';
    }
}