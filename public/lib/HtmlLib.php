<?php
class HtmlLib {
    public $title;
    public $sytle;
    
    public static function outputHead($title,$style) {
      echo '<!DOCTYPE html>
                <head>
                    <title>' .$title .'</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="' .$style .'">
                </head>';            
    }
    
    public static function outputBodyOpen() {
      echo '<body>';            
    }
    
    public static function outputBodyClose() {
      echo '</body>';            
    }
    
    public static function outputDivOpen($class=null) {
      if($class) echo '<div class=' .$class .'>';
      else echo '<div>';
    }
    
    public static function outputDivClose() {
      '</div>';
    }
    
    public static function outputHtmlClose() {
      echo '</html>';            
    }
    
    
}
