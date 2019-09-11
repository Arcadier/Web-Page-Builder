<?php
//1.identify the type of user is logged in through the api.
include 'load_pages.php';
$userRole = getUserId();
error_log(json_encode($userRole));
//2. from the page id, get the visibility and availability values.
$page_id =  $_GET['pageid'];
$pageContent = getContent($page_id);
$url = $pageContent['ExternalURL']; 
$title  = $pageContent['Title'];
$contents = $pageContent['Content'];
$isVisible = $pageContent['VisibleTo'];
//====================META=============
$meta = $pageContent['Meta'];
$metaencode = json_decode($meta,true);
$metaTitle = $metaencode['title'];
$metaDesc =  $metaencode['desc']; ?>
<!-- begin header -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $metaTitle; ?></title>
<head>
    
<link href="css/styles.css" rel="stylesheet" type="text/css">
<meta name = "description" content = "<?php echo $metaDesc;?>">                                 
</head>
<!-- end header -->

<?php
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
$urlexp =   explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); 
$host = $urlexp[0];
$host1 = $urlexp[1];
$host2 =$urlexp[2];
$host3 = $urlexp[3];
$host4 = $urlexp[4];
$host5 = $urlexp[5];

$userpage =  $protocol . '://'.$host1 . '/' .  'user' .'/' .'marketplace' . '/' . 'customlogin' . '?' . 'returnUrl='. urlencode($url); 
$userpage_buyer =  $protocol . '://'.$host1 . '/' .  'user' .'/' .'marketplace' . '/' . 'customlogin' . '?' . 'isSeller=false' . '&' . 'returnUrl='. urlencode($url);
$isAvailable = $pageContent['Available'];
$error404 = 'Error 404';
$errorContent = 'Oops! We couldn’t find the page you’re looking for.'; // if the page is hidden.
$errorRestricted = 'Sorry, you are not authorized to view this page.'; // if the user is restricted to view the page.
$errorDescription = 'Unauthorized Access';
$successDescription = 'Published and user is authorized to view.';
//===============================3. Validate first if the Page content is Published or Hidden
if($isAvailable == 'Hide'){ //if hidden, return the 404 page.
    displayPage($title,$errorContent,'1');
} else { //otherwise, return the page content depending it's availability on the logged in users.
 //===============================4. Set conditions depending on user roles.=====================================================================
 $isAnonymous = 1; 
 $isMerchant = 0;
 $isConsumer= 0;
 $isMerchantandConsumer = 0;

        if(in_array('Merchant',$userRole) || in_array('SubMerchant', $userRole)) { 
            $isMerchant = 1;
            error_log('ismerch ' . $isMerchant);
        }
        elseif(in_array('User',$userRole)){
            $isConsumer =  1;
        }
            //if the user is both merchant and at the same time, a consumer
        elseif (in_array('Merchant',$userRole) || in_array('User', $userRole) || in_array('Admin', $userRole) ){
                $isMerchantandConsumer = 1;
                error_log($isMerchantandConsumer);
        }
        else {
            //set another condition here, 
        }
//================================4. Display and load the page if it is a valid user ======================================================================= 
if($isMerchant == 1 && $isVisible == 'MerchantOnly') {
    displayPage($title,$contents,'0');
} elseif($isMerchantandConsumer == 1 && $isVisible == 'MerchantAndConsumer') {
    displayPage($title,$contents,'0');
} elseif($isVisible == 'All') {
    displayPage($title,$contents,'0');
}elseif ($isMerchant == 1 && $isVisible == 'MerchantAndConsumer') {
    displayPage($title,$contents,'0');
}elseif($isMerchantandConsumer == 0 && $isVisible == 'MerchantOnly'){
    displayPage($title,$contents,'1');
}elseif($isConsumer == 1 && $isVisible == 'MerchantOnly'){
    displayPage($title,$contents,'1');
}
else {
   header("Location:" . $userpage);
}}  ?>

<?php
function displayPage($title,$content,$isError){
echo  "<head>";
    echo   "<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />";
echo "</head>";

echo "<body>";
   echo  "<div style='margin: auto; width: 100%; height: 100%; background: #fafafa; color: #b3b3b3; padding-top: 40px; text-align: center; box-sizing: border-box;'>";
   
           if ($isError == '1'){
              echo  "<p style='margin: 0;'>";
                   echo "<img style='max-width: 98%; vertical-align: middle; border: 0; box-sizing: border-box;' src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iMjg5LjU1MnB4IiBoZWlnaHQ9IjM1OS43MDFweCIgdmlld0JveD0iMCAwIDI4OS41NTIgMzU5LjcwMSIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjg5LjU1MiAzNTkuNzAxIg0KCSB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnIGlkPSJYTUxJRF8zXyI+DQoJPHBhdGggaWQ9IlhNTElEXzIzM18iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIGQ9Ik01OC41ODIsMTAxLjVWMzcuODQzaDEyMS4zMzMNCgkJYzAsMCwxMi42NjctMiwyMi42NjcsOC42NjdsMTYuNjY3LDE3LjMzM2MwLDAsNC42NjYsNS4zMzMsNC42NjYsMTIuNjY3VjEwMS41SDU4LjU4MnoiLz4NCgk8cGF0aCBpZD0iWE1MSURfMjMyXyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQjNCM0IzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgZD0iTTIzNy41ODIsMTUxLjE3NmgtMTkyDQoJCWMtMi43NSwwLTUtMi4yNS01LTVWMTA2LjVjMC0yLjc1LDIuMjUtNSw1LTVoMTkyYzIuNzUsMCw1LDIuMjUsNSw1djM5LjY3NkMyNDIuNTgyLDE0OC45MjYsMjQwLjMzMiwxNTEuMTc2LDIzNy41ODIsMTUxLjE3NnoiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzIzNV8iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHgxPSI1OC41ODIiIHkxPSIxNTEuMTc2IiB4Mj0iNTguNTgyIiB5Mj0iMjI1LjE3NiIvPg0KCQ0KCQk8bGluZSBpZD0iWE1MSURfMjM2XyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQjNCM0IzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgeDE9Ijc2LjU4MiIgeTE9IjE1MS4xNzYiIHgyPSI3Ni41ODIiIHkyPSIyMDkuODQzIi8+DQoJDQoJCTxsaW5lIGlkPSJYTUxJRF8yMzdfIiBmaWxsPSJub25lIiBzdHJva2U9IiNCM0IzQjMiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiB4MT0iOTQuNTgyIiB5MT0iMTUxLjE3NiIgeDI9Ijk0LjU4MiIgeTI9IjIxOS44NDMiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzIzOF8iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHgxPSIxMTIuNTgyIiB5MT0iMTUxLjE3NiIgeDI9IjExMi41ODIiIHkyPSIyMDUuNTEiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzIzOV8iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHgxPSIxMzAuNTgyIiB5MT0iMTUxLjE3NiIgeDI9IjEzMC41ODIiIHkyPSIxOTMuODQzIi8+DQoJDQoJCTxsaW5lIGlkPSJYTUxJRF8yNDBfIiBmaWxsPSJub25lIiBzdHJva2U9IiNCM0IzQjMiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiB4MT0iMTQ4LjU4MiIgeTE9IjE1MS4xNzYiIHgyPSIxNDguNTgyIiB5Mj0iMjQzLjE3NiIvPg0KCQ0KCQk8bGluZSBpZD0iWE1MSURfMjQxXyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQjNCM0IzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgeDE9IjE2Ni41ODIiIHkxPSIxNTEuMTc2IiB4Mj0iMTY2LjU4MiIgeTI9IjIyNS4xNzYiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzI0Ml8iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHgxPSIxODQuNTgyIiB5MT0iMTUxLjE3NiIgeDI9IjE4NC41ODIiIHkyPSIxODguMTc2Ii8+DQoJDQoJCTxsaW5lIGlkPSJYTUxJRF8yNDNfIiBmaWxsPSJub25lIiBzdHJva2U9IiNCM0IzQjMiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiB4MT0iMjAyLjU4MiIgeTE9IjE1MS4xNzYiIHgyPSIyMDIuNTgyIiB5Mj0iMjEzLjI0MyIvPg0KCQ0KCQk8bGluZSBpZD0iWE1MSURfMjQ0XyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQjNCM0IzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgeDE9IjIyMC41ODIiIHkxPSIxNTEuMTc2IiB4Mj0iMjIwLjU4MiIgeTI9IjI1OS4xNzYiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzI0NV8iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHgxPSIyMzguNTgyIiB5MT0iMTUxLjE3NiIgeDI9IjIzOC41ODIiIHkyPSIyMDUuMTc2Ii8+DQoJDQoJCTxsaW5lIGlkPSJYTUxJRF8yNThfIiBmaWxsPSJub25lIiBzdHJva2U9IiNCM0IzQjMiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2UtZGFzaGFycmF5PSIyIiB4MT0iNTguNTgyIiB5MT0iMjMxLjU4MyIgeDI9IjU4LjU4MiIgeTI9IjMwNS41ODMiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzI1N18iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS1kYXNoYXJyYXk9IjIiIHgxPSI3Ni41ODIiIHkxPSIyMTUuOTE3IiB4Mj0iNzYuNTgyIiB5Mj0iMjc0LjU4MyIvPg0KCQ0KCQk8bGluZSBpZD0iWE1MSURfMjU2XyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQjNCM0IzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgc3Ryb2tlLWRhc2hhcnJheT0iMiIgeDE9Ijk0LjU4MiIgeTE9IjIyNi41ODMiIHgyPSI5NC41ODIiIHkyPSIyOTUuMjUiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzI1NV8iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS1kYXNoYXJyYXk9IjIiIHgxPSIxMTIuNTgyIiB5MT0iMjEzLjI0MyIgeDI9IjExMi41ODIiIHkyPSIyNjcuNTc2Ii8+DQoJDQoJCTxsaW5lIGlkPSJYTUxJRF8yNTRfIiBmaWxsPSJub25lIiBzdHJva2U9IiNCM0IzQjMiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2UtZGFzaGFycmF5PSIyIiB4MT0iMTMwLjU4MiIgeTE9IjIwMC41MSIgeDI9IjEzMC41ODIiIHkyPSIyNDMuMTc2Ii8+DQoJDQoJCTxsaW5lIGlkPSJYTUxJRF8yNTNfIiBmaWxsPSJub25lIiBzdHJva2U9IiNCM0IzQjMiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2UtZGFzaGFycmF5PSIyIiB4MT0iMTQ4LjU4MiIgeTE9IjI1MS41ODMiIHgyPSIxNDguNTgyIiB5Mj0iMjk0LjI2OSIvPg0KCQ0KCQk8bGluZSBpZD0iWE1MSURfMjQ4XyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQjNCM0IzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgc3Ryb2tlLWRhc2hhcnJheT0iMiIgeDE9IjE2Ni41ODIiIHkxPSIyMzEuNTgzIiB4Mj0iMTY2LjU4MiIgeTI9IjMwNS41ODMiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzE5N18iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS1kYXNoYXJyYXk9IjIiIHgxPSIxODQuNTgyIiB5MT0iMTk1LjQxNyIgeDI9IjE4NC41ODIiIHkyPSIyMzIuNDE3Ii8+DQoJDQoJCTxsaW5lIGlkPSJYTUxJRF8yM18iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS1kYXNoYXJyYXk9IjIiIHgxPSIyMDIuNTgyIiB5MT0iMjIwLjU1IiB4Mj0iMjAyLjU4MiIgeTI9IjI4Mi42MTciLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzIyXyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQjNCM0IzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgc3Ryb2tlLWRhc2hhcnJheT0iMiIgeDE9IjIyMC41ODIiIHkxPSIyNjcuMjY5IiB4Mj0iMjIwLjU4MiIgeTI9IjMyMS4yNjkiLz4NCgkNCgkJPGxpbmUgaWQ9IlhNTElEXzVfIiBmaWxsPSJub25lIiBzdHJva2U9IiNCM0IzQjMiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2UtZGFzaGFycmF5PSIyIiB4MT0iMjM4LjU4MiIgeTE9IjIxMy40MSIgeDI9IjIzOC41ODIiIHkyPSIyNjcuNDEiLz4NCgk8cG9seWxpbmUgaWQ9IlhNTElEXzI0Nl8iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHBvaW50cz0iNzYuNTgyLDc1LjE3NiANCgkJOTcuOTE2LDU3Ljg0MyAxMTcuMjQ5LDc1LjE3NiAxMzYuNTgyLDU3Ljg0MyAxNTUuMjQ5LDc1LjE3NiAxNzMuOTE1LDU3Ljg0MyAJIi8+DQoJPHBvbHlsaW5lIGlkPSJYTUxJRF8yMzRfIiBmaWxsPSJub25lIiBzdHJva2U9IiNCM0IzQjMiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBwb2ludHM9IjE4Ny45NjQsMzguMjcxIA0KCQkxODcuOTY0LDc1LjE3NiAyMjMuOTE1LDc1LjE3NiAJIi8+DQoJDQoJCTxjaXJjbGUgaWQ9IlhNTElEXzI0N18iIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0IzQjNCMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIGN4PSIyMDAuMjQ5IiBjeT0iMTI0LjE3NiIgcj0iOC4zMzMiLz4NCgkNCgkJPGNpcmNsZSBpZD0iWE1MSURfMjUwXyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQjNCM0IzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgY3g9IjIyMC41ODIiIGN5PSIxMjQuMTc2IiByPSI4LjMzMyIvPg0KPC9nPg0KPC9zdmc+DQo=' />";
               echo "</p>";
               echo "<h2 style='font-family: Oswald,sans-serif; color: #333; font-size: 80px; margin: 0 0 10px 0; font-weight: 500; line-height: 1.1; box-sizing: border-box;'>404</h2>";
               echo "<p>" . 'Sorry! Something seems to have gone wrong.' . "</p>";
           }
           else {
            echo   "<h1 class='display-4'>" . $title. "</h1>";
            echo "<hr>";

            echo "</div>";
            echo "<div style = 'margin-left: 30px; margin-right: 20px;' >";
                            echo  $content ; 
            echo "  </div>";
           }
           
         echo "  </div>";
        echo "</div>";
 
}
function getUserId(){
    $baseUrl = getMarketplaceBaseUrl();
    $admin_token = getAdminToken();
    $userToken = $_COOKIE["webapitoken"];
    error_log('usertoken ' . $userToken);
    $url = $baseUrl . '/api/v2/users/'; 
    error_log('this is the url ' . $url);
    $result = callAPI("GET", $userToken, $url, false);
    error_log('api result ' . json_encode($result));
    $userRole = $result['Roles'];
    if ($userRole == '') {
        $userRole = ['Guest'];
        return $userRole;
    }
    else {
        return $userRole;
    }
}
    //reserve function
    function meta($pgKeywords,$pgDesc)
    {?>
        <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
         <meta name="keywords" content="<?php echo $pgKeywords ?>">
         <meta name="description" content="<?php echo $pgDesc ?>"><?php
     }?>
