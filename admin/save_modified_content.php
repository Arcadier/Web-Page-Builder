<?php
include 'callAPI.php';
include 'admin_token.php';
$contentBodyJson = file_get_contents('php://input');
$content = json_decode($contentBodyJson, true);
$timezone = $content['timezone']; 
$timezone_name = timezone_name_from_abbr("", $timezone*60, false);
date_default_timezone_set($timezone_name);
$pageId = $content['pageId'];
$userId = $content['userId'];
$title = $content['title'];
$contents = $content['content'];
$url = $content['pageURL'];
$isAvailbleTo = $content['availability'];
$isVisibleTo = $content['visibility'];
$metadesc = $content['metadesc'];
$shortURL = $content['pageURLshort'];
$meta = array('title' => $title , 'desc'=> $metadesc);
$meta2 = json_encode($meta);
$baseUrl = getMarketplaceBaseUrl();
$admin_token = getAdminToken();
$customFieldPrefix = getCustomFieldPrefix();

$data = [
    'Title' => $title,
    'Content' => $contents,
    'ExternalURL'=> $url,
    'ModifiedDateTime' => "",
    'Active' => true,
    'Available' => $isAvailbleTo,
    'VisibleTo' => $isVisibleTo,
    'Meta' => $meta2,     
];
$url = $baseUrl . '/api/v2/content-pages/'.$pageId;
$result = callAPI("PUT", $admin_token['access_token'], $url, $data);

//3.get the value of long page url
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
$urlexp =   explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); 
$host  = $urlexp[0];
$host1 = $urlexp[1];
$host2 = $urlexp[2];
$host3 = $urlexp[3];
$host4 = $urlexp[4];
$host5 = $urlexp[5]; 
$pathURL =  '/' .  'user' .'/' . $host2 . '/' . $host3 . '/'. 'getpages.php' . '?pageid=' . $pageId;
// POST THE DATA
$data = [
    'Key' => $shortURL,
    'Value' => $pathURL,
];

$url = $baseUrl . '/api/v2/rewrite-rules';
$result = callAPI("POST", $admin_token['access_token'], $url, $data);

?>