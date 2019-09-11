
<?php
include 'load_pages.php';
$page_id = $_GET['pageid'];
$pageContent = getContent($page_id);

$url = $pageContent['ExternalURL']; 
$isVisible = $pageContent['VisibleTo'];
$isAvailable = $pageContent['Available'];
error_log($isAvailable);
// meta details
$meta = $pageContent['Meta'];
$metaencode = json_decode($meta,true);
$metaTitle = $metaencode['title'];
$metaDesc =  $metaencode['desc'];
$sliceURL = strstr($url, 'pages/');
$remSlash = strstr($sliceURL, '/');
$webURL = ltrim($remSlash,"/");
$trimURL=preg_replace('/\s+/', '', $webURL);

//preview page URL
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
 $urlexp =   explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); 
 $host = $urlexp[0];
 $host1 = $urlexp[1];
 $host2 =$urlexp[2];
 $host3 = $urlexp[3];
 $host4 = $urlexp[4];
 $host5 = $urlexp[5];
 $userpage =  $protocol . '://'.$host1 . '/' .  'user' .'/' . $host2 . '/' . $host3 . '/'. 'show_preview.php';
?>

<title>Pages Edit</title>
<!-- begin header -->
<script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
<!-- package css-->
<link href="css/pages-package.css" rel="stylesheet" type="text/css">
<style>
.texteditor-container {	
	width:700px;
	height:365px;
}
textarea#editor1 {
	width:500px !important;
	border:1px solid red;	
}
</style>
<!-- end header -->
    <div class="page-content">
      <div class="gutter-wrapper">
      <input type = "hidden" id="urlpath" value = <?php echo $userpage; ?>>
        <form >
        <div class="panel-box">
          <div class="page-content-top">
            <div> <i  class="icon icon-pages icon-3x"></i> </div>
              <div>
                  <span>Add new pages to your marketplace</span> 
              </div>
              <div class="private-setting-switch">
               <a href="#" class="btn-black-mdx" id = "showpreviewEdit">Preview</a>
                 <span  class="grey-btn btn_delete_act">Cancel</span>
                 <a href="#" class="save-btn" id="edit">Save</a>

                 <input type="hidden" id="pageid"  value="<?php echo $page_id; ?>">
              </div>
          </div>
        </div>
          
          <div class="row pgcreate-frmsec">
              <div class="col-md-8 pgcreate-frm-l ">
                <div class="panel-box">
                    <div class="pgcreate-frmarea form-area">
                        <div class="row">
                        <div class="col-md-7">
                           <div class="form-group ">
                              <label class="">Page Title</label>
                              <input class="form-control" type="text" name="pg_title" value ="<?php echo $pageContent['Title'];?>" id = "title"/>
                           </div>
                        </div>   
                        <div class="col-md-12">
                          <label class="">Content</label> <br>
                            <textarea class = "ckeditor" name="editor1" id="editor1"><?php echo $pageContent['Content']; ?> </textarea>
                        </div>  
                        <div id="display-post" style="width:700px;" ></div>
                        <div class="clearfix"></div>
                        </div>
                    </div>

                </div>

                <div class="panel-box">

                      <div class="pgcreate-frmarea  pgcrt-meta-seosec">
                            <h4 id = "seotitle"><?php echo $metaTitle; ?></h4>
                            <div class="pgcrt-meta-seobtn">
                                <span class="pgcrt-link-cstmseo">Edit</span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="seopg-link" id ="seolink"><?php echo $url; ?></div>  
                            <p id = "seodesc"> <?php echo $metaDesc ?></p>
                      </div>

                      <div class="pgcreate-frmarea  pgcrt-meta-seoeditsec hide">
                            <div class="pgcrt-meta-seoedit">
                               <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group ">
                                          <label class="">Meta Title (Maximum characters: 65)</label>
                                          <input class="form-control" type="text" name="meta_title"  id="metatitle" value = "<?php echo $metaTitle; ?>"  />
                                       </div>
                                   </div>
                                   <div class="col-md-6 pgcrtseo-aplybtnsec">
                                        <span class="pgcrtseo-aplyllink" id ="editContent">Save</span>
                                   </div> 

                                   <div class="col-md-12">
                                       <div class="form-group ">
                                          <label class="">Web URL</label>
                                          <div class="pgcrtseo-weburlsec">
                                              <span id = "marketplaceURL"></span>
                                              <input  type="text" name="meta_weburl" id="metaurl"  value= "<?php echo $trimURL;?>" />
                                          </div>        
                                       </div>
                                   </div>

                                   <div class="col-md-12">
                                       <div class="form-group ">
                                          <label class="">Meta Description (Maximum characters: 170)</label>
                                          <textarea class="form-control" name="meta_desc" id="metadesc"  maxlength="300"><?php echo $metaDesc; ?></textarea>
                                       </div>
                                   </div>
                               </div>

                            </div>    
                            <div class="pgcreat-btmbtn-sec">
                    <div class="clearfix"></div>
                </div>
                      </div>
                   
                </div>  

              </div>
              <div class="col-md-4 pgcreate-frm-r">
                 <div class="panel-box">
                    <div class="pgcreate-sbar">
                        <div class="pgcreate-sbar-title">Status</div>
                        <div class="pgcreate-sbardesc ">
                            <div class="pgcreate-sbarcon pgfncyopt">
                                <div class="fancy-radio">
                                    <input type="radio" value="0"  <?php echo ($isAvailable == "Publish") ?  "checked" : "" ; ?> name="opt_del" id="pg_avail_pub"  class="" id = "available">
                                    <label for="pg_avail_pub"><span>Published</span></label>
                                  </div>
                            </div>

                            <div class="pgcreate-sbarcon pgfncyopt">
                                <div class="fancy-radio">
                                    <input type="radio" value="1" <?php echo ($isAvailable == 'Hide') ?  "checked" : "" ; ?> name="opt_del" id="pg_avail_hide"  class="" id = "hide">
                                    <label for="pg_avail_hide">Hidden</label>
                                  </div>
                            </div>
                        </div>
                    </div>
                 </div>

                 <div class="panel-box">
                    <div class="pgcreate-sbar">
                        <div class="pgcreate-sbar-title">Visibility</div>
                        <div class="pgcreate-sbardesc ">
                            <div class="pgcreate-sbarcon pgfncyopt">
                                <div class="fancy-radio">
                                    <input type="radio" value="0"  <?php echo ($isVisible == "All") ?  "checked" : "" ; ?> name="visible-to" id="visible-to1"  class="">
                                    <label for="visible-to1"><span>All users</span></label>
                                  </div>
                            </div>

                            <div class="pgcreate-sbarcon pgfncyopt">
                                <div class="fancy-radio">
                                    <input type="radio" value="1" <?php echo ($isVisible == "MerchantAndConsumer") ?  "checked" : "" ; ?> name="visible-to" id="visible-to2"  class="">
                                    <label for="visible-to2">Merchants and Registered Buyer</label>
                                  </div>
                            </div>
                             <div class="pgcreate-sbarcon pgfncyopt">
                                <div class="fancy-radio">
                                    <input type="radio" value="2" <?php echo ($isVisible == "MerchantOnly") ?  "checked" : "" ; ?> name="visible-to" id="visible-to3"  class="">
                                    <label for="visible-to3">Merchants only</label>
                                  </div>
                            </div>
                            
                        </div>
                    </div>
                 </div>

                
              </div>
              <div class="clearfix"></div>
          </div>
          </form>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
<!-- </div> -->

<div class="popup  popup-area popup-delete-confirm " id="DeleteCustomMethod">
  <div class="wrapper"> <span class="close-popup"><img src="images/cross-icon.svg"></span>
    <div class="content-area">
      <p>Are you sure you want to cancel this?</p>
    </div>
    <div class="btn-area text-center smaller">
      <input  type="button" value="Cancel" class="btn-black-mdx " id="popup_btncancel">
      <input id="popup_btnconfirm_cancel" type="button" value="Okay" class="my-btn btn-blue">
      <div class="clearfix"></div>
    </div>
  </div>
</div>

<div id="cover"></div>

   <!-- begin footer -->

   <script>
                CKEDITOR.replace( 'editor1', {
                                
    toolbar: [
    { name: 'document', groups: ['document', 'doctools' ], items: [ 'Preview', 'Source'] },
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: ['-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-'] },
    { name: 'forms', items: [ 'Checkbox', 'Radio'] },
    '/',
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-'] },
    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',  '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-'] },
    { name: 'links', items: [ 'Link', 'Unlink'] },
    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar'] },
    '/',
    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
    { name: 'colors', items: [ 'TextColor', 'BGColor','youtube' ] },
]
});     

        CKEDITOR.config.removePlugins = 'elementspath';

            </script>

<script type="text/javascript">
    
    jQuery(document).ready(function() {

    metadesc.onkeyup = metadesc.onpaste= function(e){
    e = e || window.event;
    var who= e.target || e.srcElement;
    if(who){
        var val= who.value, L= val.length;
        if(L> 300){
            who.style.color= 'red';
        }
        else who.style.color= ''
        if(L> 300){
            who.value= who.value.substring(0, 300);
            alert('Your message is too long, please shorten it to 300 characters or less');
            who.style.color= '';
        }
    }
}
      
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


         jQuery('.pgcrt-link-cstmseo').click(function(){  
              jQuery('.pgcrt-meta-seosec').addClass('hide');
              jQuery('.pgcrt-meta-seoeditsec').removeClass('hide');
         });


         jQuery('.pgcrtseo-canclelink').click(function(){  
              jQuery('.pgcrt-meta-seosec').removeClass('hide');
              jQuery('.pgcrt-meta-seoeditsec').addClass('hide');
         });

         jQuery('.pgcrtseo-aplyllink').click(function(){  
        
         });


         jQuery('.btn_delete_act').click(function(){  
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

        //pre fill the meta title with the page title
        $("#title").keyup(function(){
          $("#metatitle").val($('#title').val());

      });
      
    }); 
    
    </script> 
<script type="text/javascript" src="scripts/package.js"></script>
<!-- end footer --> 
