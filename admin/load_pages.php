<?php
include 'callAPI.php';
include 'admin_token.php';
function getContent($pageID) {
    $baseUrl = getMarketplaceBaseUrl();
    $admin_token = getAdminToken();
    $customFieldPrefix = getCustomFieldPrefix();
    $url = $baseUrl . '/api/v2/content-pages/'.$pageID; 
    error_log('this is the url ' . $url);
    $getContent = callAPI("GET", $admin_token['access_token'], $url, false);
    error_log('Content ' . json_encode($getContent));
    return $getContent;
}
?>