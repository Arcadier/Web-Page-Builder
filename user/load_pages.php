<?php
include 'callAPI.php';
include 'admin_token.php';

function getContent($pageID) {
    $baseUrl = getMarketplaceBaseUrl();
    $admin_token = getAdminToken();
    $customFieldPrefix = getCustomFieldPrefix();
    $url = $baseUrl . '/api/v2/content-pages/'.$pageID; 
    $getContent = callAPI("GET", $admin_token['access_token'], $url, false);
    return $getContent;
}

function getPreview($page){
    $baseUrl = getMarketplaceBaseUrl();
    $admin_token = getAdminToken();
    $customFieldPrefix = getCustomFieldPrefix();
    $url = $baseUrl . '/api/v2/marketplaces/'; 
    $marketplaceInfo = callAPI("GET", $admin_token['access_token'], $url, false);
  
    foreach ($marketplaceInfo['CustomFields'] as $cf) {
        if ($cf['Name'] == $page && substr($cf['Code'], 0, strlen($customFieldPrefix)) == $customFieldPrefix) {
            $pageContent = $cf['Values'][0];
        }
        if ($pageContent == ''){
            $pageContent =  'No preview Available';
        }
    }
    return $pageContent;
}

?>