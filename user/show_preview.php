<!-- begin header -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<!-- end header -->
<?php
include 'load_pages.php';
$content = getPreview('Preview');
$title =  getPreview('Page Title');

echo "<body>";
   echo  "<div style='margin: auto; width: 100%; height: 100%; background: #fafafa; color: #b3b3b3; padding-top: 40px; text-align: center; box-sizing: border-box;'>";
     echo   "<h1 class='display-4'>" . $title. "</h1>";
     echo "<hr>";

     echo "</div>";
     echo "<div style = 'margin-left: 30px; margin-right: 20px;' >";
                     echo  $content ; 
     echo "  </div>";

echo  "</div>";    
echo "</div>";

?>


