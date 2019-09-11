<?php
include 'callAPI.php';
include 'admin_token.php';
$contentBodyJson = file_get_contents('php://input');
$content = json_decode($contentBodyJson, true);
$timezone = $content['timezone'];  
$tz = date_default_timezone_get();
$timezone_name = timezone_name_from_abbr("", $timezone*60, false);
date_default_timezone_set($timezone_name);
$timestamp = date("d/m/Y H:i"); 
$timestamp2 = $timezone*60;

$userId = $content['userId'];
$title = $content['title'];
$contents = $content['content'];
$urls = $content['pageURL'];
$isAvailbleTo = $content['availability'];
$isVisibleTo = $content['visibility'];
$metadesc = $content['metadesc'];
$shortURL = $content['pageURLshort'];
$meta = array('title' => $title , 'desc'=> $metadesc);
$meta2 = json_encode($meta);
$stylepath = $content['stylesheet'];

$baseUrl = getMarketplaceBaseUrl();
$admin_token = getAdminToken();
$customFieldPrefix = getCustomFieldPrefix();

$data = [
    'Title' => $title,
    'Content' => $contents,
    'ExternalURL'=> $urls,
    'CreatedDateTime' => $timestamp2,
    'ModifiedDateTime' => $timestamp2,
    'Active' => true,
    'Available' => $isAvailbleTo,
    'VisibleTo' => $isVisibleTo,
    'Meta' => $meta2,     
];
$url = $baseUrl . '/api/v2/content-pages';
$result = callAPI("POST", $admin_token['access_token'], $url, $data);

//1.get the ID of the response
 $pageid =  $result['ID'];
 $meta = $result['Meta'];
 $metaencode = json_decode($meta,true);

//2.get the value of the short and long url
$pageURL =  '/' . 'pages/' .$urls;
//3.get the value of long page url
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
$urlexp =   explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); 
$host  = $urlexp[0];
error_log('host' . $host);
$host1 = $urlexp[1];
error_log('host1' . $host1);
$host2 = $urlexp[2];
error_log('host2' . $host2);
$host3 = $urlexp[3];
error_log('host3' . $host3);
$host4 = $urlexp[4];
error_log('host4' . $host4);
$host5 = $urlexp[5]; 
error_log('host5' . $host5);

$pathURL =  '/' .  'user' .'/' . $host2 . '/' . $host3 . '/'. 'getpages.php' . '?pageid=' . $pageid;
// POST THE DATA
$data = [
    'Key' => $shortURL,
    'Value' => $pathURL,

];
$url = $baseUrl . '/api/v2/rewrite-rules';
$result = callAPI("POST", $admin_token['access_token'], $url, $data);

$styles = [
    'Key' => '/pages/css/styles.css',
    'Value' => '/' .  'user' .'/' . $host2 . '/' . $host3 . '/'. 'css' . '/' . 'styles.css',

    
];

$url = $baseUrl . '/api/v2/rewrite-rules';
$result = callAPI("POST", $admin_token['access_token'], $url, $styles);

?>
