<?php
/*
  This php script extract all the file contained in $dir_txt and $dir_html
  to index them in the table pages of our database.
  To have an accurate research later, we attribute differents weigths
  to texts depending of the importance of their part.
*/




/*
  This function extract the text in the paragraph named by $part_name in the
  string $html containing the entire man page under html form
*/
function extract_texte($html, $part_name)
{
   $pattern_start = '<h2 class="nroffsh">'.$part_name.'</h2>';
   $pattern_end="<h2";
   $retour = "";
   $pos= strpos($html, $pattern_start);
   if (!($pos===false)) {
     $retour = substr($html, $pos + strlen($pattern_start)) ;
     $pos = strpos($retour, $pattern_end);
     if (!($pos===false)) {
       $retour = substr($retour, 0, $pos);
     }
   }
   return strip_tags($retour);
}

include('bdd.php');
$dir_txt = "man_txt/man1";
$dir_html = "man_html/man1";
$extension = ".1.txt";
$extension_html = ".1.html";
$files = scandir($dir_txt);
echo "</br>";
foreach ($files as $file){
    
    $page_name = substr($file , 0 , -(strlen($extension)));
    
    if (!is_dir($dir_txt."/".$file)){
      echo $page_name . "</br>";
      $file_content = "";
      $file_content = file_get_contents($dir_txt."/".$file);
      $file_content_html = "";
      $file_content_html = file_get_contents($dir_html."/".$page_name.$extension_html);

      try{
          $query = "INSERT INTO pages VALUES ('$page_name','".
          str_replace ("'","''",$file_content)."','".
          str_replace ("'","''",$file_content_html)."',".
          "( ".
          "setweight(to_tsvector('".str_replace ("'","''",extract_texte($file_content_html,"NAME"))."'), 'A') ||".
          //"setweight(to_tsvector('".$page_name."'), 'A') ||".
          "setweight(to_tsvector('".str_replace ("'","''",extract_texte($file_content_html,"DESCRIPTION"))."'), 'B') ||".
          "setweight(to_tsvector('".str_replace ("'","''",extract_texte($file_content_html,"SYNOPSIS"))."'), 'C') ||".
          "setweight(to_tsvector('".str_replace ("'","''",extract_texte($file_content_html,"OPTION"))."'), 'C') ||".
          "setweight(to_tsvector('".str_replace ("'","''",extract_texte($file_content_html,"ERRORS"))."'), 'C') ||".
          "setweight(to_tsvector('".str_replace ("'","''",extract_texte($file_content_html,"NOTES"))."'), 'C') ||".
          "setweight(to_tsvector('".str_replace ("'","''",extract_texte($file_content_html,"EXAMPLE"))."'), 'C') ||".
          
          "to_tsvector('".str_replace ("'","''",$file_content)."')  ) ) ";
          $bdd->exec($query);
      }
      catch (Exception $e)
      {
                die('Erreur : ' . $e->getMessage());
      }
  }
}
echo "It's works</br>";

?>
