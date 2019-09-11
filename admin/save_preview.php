<?php
include 'callAPI.php';
include 'admin_token.php';

$contentBodyJson = file_get_contents('php://input');
$content = json_decode($contentBodyJson, true);
$pageContent = $content['page'];
$pageTitle =   $content['title'];

$userId = $content['userId'];
//content
$baseUrl = getMarketplaceBaseUrl();
$admin_token = getAdminToken();
$customFieldPrefix = getCustomFieldPrefix();

// Query to get marketplace id
$url = $baseUrl . '/api/v2/marketplaces/';
$marketplaceInfo = callAPI("GET", null, $url, false);

// Query to get package custom fields
$url = $baseUrl . '/api/developer-packages/custom-fields?packageId=' . getPackageID();
$packageCustomFields = callAPI("GET", null, $url, false);

//========================================================================************PREVIEW SAVING*************************===================================================
$previewCode = '';
$titleCode = '';
foreach ($packageCustomFields as $cf) {

    if ($cf['Name'] == 'Preview' && substr($cf['Code'], 0, strlen($customFieldPrefix)) == $customFieldPrefix) {
           $previewCode = $cf['Code'];
    }
    
    if ($cf['Name'] == 'Page Title' && substr($cf['Code'], 0, strlen($customFieldPrefix)) == $customFieldPrefix) {
        $titleCode = $cf['Code'];
 }
}
$data = [
    'ID' => $marketplaceInfo['ID'],
    'CustomFields' => [
        [
            'Code' => $previewCode,
            'Values' => [$pageContent],
        ],
        [
            'Code' => $titleCode,
            'Values' => [$pageTitle],
        ],

       
    ],
];
$id =  $marketplaceInfo['ID'];
$url = $baseUrl . '/api/v2/marketplaces/';
$result = callAPI("POST", $admin_token['access_token'], $url, $data);