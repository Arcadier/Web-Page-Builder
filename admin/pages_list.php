<!-- begin header -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pages List</title>
<!-- package css-->
<link href="css/pages-package.css" rel="stylesheet" type="text/css">

<a href="https://icons8.com/icon/79906/preview-pane"></a>
<!-- end header -->
    <?php 
      include 'callAPI.php';
      include 'admin_token.php';
     $server = $_SERVER['REQUEST_TIME'];
    
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
    $urlexp =   explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); 
    $host = $urlexp[0];
    $host1 = $urlexp[1];
    $host2 =$urlexp[2];
    $host3 = $urlexp[3];
    $host4 = $urlexp[4];
    $host5 = $urlexp[5];
    $userpage =  $protocol . '://'.$host1 . '/' .  'user' .'/' . $host2 . '/' . $host3 . '/'. 'getpages.php';
   
      $contentBodyJson = file_get_contents('php://input');
      $content = json_decode($contentBodyJson, true);
      $timezone = $_GET['tz'];
   
      ?>
      <div class="clearfix"></div>
    </div>
    <div class="page-content">
    <div class = "page-pages-list">
      <div class="gutter-wrapper">
        <div class="panel-box">
          <div class="page-content-top">
            <div> <i class="icon icon-pages icon-3x"></i> </div>
            <div>
              <p>Add new pages to your marketplace</p>
            </div>
            <div class="private-setting-switch">
              <a href="create_page.php" class="blue-btn">Create New Page</a>
            </div>
          </div>
        </div>
     
        <div class="panel-box" style= "margin-right:10px" >
        <div> </div>
            <div class="blsl-list-tblsec">
                <table id="no-more-tables1">
                <thead>
                       <tr>
                       
                         <th id="page-title">Page Title<i class="icon icon-white-up"><i class="icon icon-white-down"></i></i></th>

                         <th>Visibility</th>

                         <th id="last-updated">Last Updated<i class="icon icon-white-up"><i class="icon icon-white-down"></i></i></th>

                         <th>Status</th>

                         <th>Actions</th>

                       </tr> 
                    </thead>
                    <tbody>
                  <tr>
                       <?php  
                          $baseUrl = getMarketplaceBaseUrl();
                          $admin_token = getAdminToken();
                          $customFieldPrefix = getCustomFieldPrefix();

                          $url = $baseUrl . '/api/v2/content-pages'; 
                          $getPages = callAPI("GET", $admin_token['access_token'], $url, false);

                          foreach($getPages['Records'] as $page) {
                            $metaencode = json_decode($page['Meta'],true);
                            $metaPage = $metaencode['blogPageOnly'];
                    
                            if (strpos($page['ExternalURL'], 'pages') && $metaPage!='yes') {
                       
                                  $timezone_name = timezone_name_from_abbr("", $timezone*60, false);
                                  date_default_timezone_set($timezone_name);
                                    $pageID = $page['ID'];
                                    $title  = $page['Title']; 
                                    $visibility = $page['VisibleTo'];
                                    //fix the string 
                                  
                                    if ($visibility == 'MerchantAndConsumer') { $visibility = 'Merchant and Consumer'; }
                                    elseif ($visibility == 'MerchantOnly') { $visibility = 'Merchant Only';}
                                    elseif ($visibility == 'All') {$visibility = 'All Users';}
                                    $availability = $page['Available'];
                                    //change Hide to 'Hidden'
                                    if ($availability == 'Hide') { $availability = 'Hidden';}
                                    if ($availability == 'Publish') { $availability = 'Published';}
                                    $serverdate = $page['ModifiedDateTime'];
                                    $date = date('d/m/Y H:i', $serverdate);
                                    echo  "<td style='padding-right:15px'>" .  $title . "</td>";
                                    echo "<td>";
                                    echo  "<ul>";
                                    echo   $visibility;
                                    echo "</ul>";
                                    echo "</td>";
                                    echo "<td>" .  $date . " </td>";  
                                    echo "<td>" .  $availability . "</td>";
                                    echo "<td style='display:inline-flex'>";
                              ?>
                                <a href="edit_content.php?pageid=<?php echo $pageID; ?>"><i class="icon icon-edit"></i></a> 
                                <a href="#" class="btn_delete_act" dir= "<?php echo $pageID; ?>" id = "del"><i class="icon icon-delete" ></i></a>
                                <a href="<?php echo $userpage . '?pageid='.$pageID; ?>" target="_blank" id="previewicon"><img src="https://img.icons8.com/ios-glyphs/30/000000/preview-pane.png"></a> 
                              
                              </td>
                          </tr>
                       <?php
                              
                        } 
                      }
               
                      ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
      
        </div>
      
      </div>
    
    </div>
  </div>
 
  </div>
  </div>
 
  <div class="clearfix"></div>
 
<!-- </div> -->

<div class="popup  popup-area popup-delete-confirm " id="DeleteCustomMethod">
    <input type="hidden" class="record_id" value="">
  <div class="wrapper"> <a href="javascript:;" class="close-popup"><img src="images/cross-icon.svg"></a>
    <div class="content-area">
      <p>Are you sure you want to delete this?</p>
    </div>
    <div class="btn-area text-center smaller">
      <input  type="button" value="Cancel" class="btn-black-mdx " id="popup_btncancel">
      <input id="popup_btnconfirm" type="button" value="Okay" class="my-btn btn-blue">
      <div class="clearfix"></div>
    </div>
  </div>
</div>

<div id="cover"></div>

 <!-- begin footer -->
<script type="text/javascript">
jQuery(document).ready(function() {
        $('#no-more-tables1').DataTable(
        {
        // "paging":   false,
        "order": [[ 0, "asc" ]],
        "lengthMenu": [[20], [20]],
        // "ordering": false,
        "info":     false,
        "searching" :false,
        "pagingType": "first_last_numbers"
        }
    );


waitForElement('#no-more-tables1_wrapper',function(){
   var pagediv =  "<div class ='paging' id = 'pagination-insert'> </div>";
   $('#no-more-tables1_wrapper').append(pagediv);
    });

    waitForElement('#no-more-tables1_length',function(){
    $('#no-more-tables1_length').css({ display: "none" });
    });

        jQuery(".mobi-header .navbar-toggle").click(function(e) {
            e.preventDefault();
            jQuery("body").toggleClass("sidebar-toggled");
        });
        jQuery(".navbar-back").click(function() {
            jQuery(".mobi-header .navbar-toggle").trigger('click');
        });

        /*nice scroll */
        jQuery(".sidebar").niceScroll({ cursorcolor: "#000", cursorwidth: "6px", cursorborderradius: "5px", cursorborder: "1px solid transparent", touchbehavior: true, preventmultitouchscrolling: false, enablekeyboard: true });

        jQuery(".sidebar .section-links li > a").click(function() {
            jQuery(".sidebar .section-links li").removeClass('active');
            jQuery(this).parents('li').addClass('active');
        });


        jQuery('.btn_delete_act').click(function(){  
            var page_id = $(this).attr('dir');
             console.log(page_id);
             $('.record_id').val(page_id);
           
            jQuery('#DeleteCustomMethod').show();
            jQuery('#cover').show();
        });

        jQuery('#popup_btnconfirm').click(function(){  

            jQuery('#DeleteCustomMethod').hide();
            jQuery('#cover').hide();
        });

        jQuery('#popup_btncancel,.close-popup').click(function(){  
            jQuery('#DeleteCustomMethod').hide();
            jQuery('#cover').hide();
        });       
    });
    

    function waitForElement(elementPath, callBack){
	window.setTimeout(function(){
	if($(elementPath).length){
			callBack(elementPath, $(elementPath));
	}else{
			waitForElement(elementPath, callBack);
	}
	},10)
}


waitForElement('#pagination-insert',function(){
var pagination  = $('#no-more-tables1_paginate');
$('#pagination-insert').append(pagination);
// $('#no-more-tables1_paginate').removeClass('dataTables_paginate paging_simple_numbers');
});


    </script> 
    <script type="text/javascript" src="scripts/package.js"></script>
    <!-- <script type="text/javascript" src="scripts/table.js"></script> -->
    <script type="text/javascript" src="scripts/jquery.dataTables.js"></script>
  
    <script>
  
        </script>
<!-- end footer --> 
