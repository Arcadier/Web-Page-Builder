
<title>Pages Create</title>
<?php 
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
<!-- begin header -->
<script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
<!-- package css-->
<link href="css/pages-package.css" rel="stylesheet" type="text/css">
<!-- end header -->
    <div class="page-content">
      <div class="gutter-wrapper">
      <input type = "hidden" id="path" value = <?php echo $userpage; ?>>

        <form >
        <div class="panel-box">
          <div class="page-content-top">
            <div> <i  class="icon icon-pages icon-3x"></i> </div>
              <div>
                  <span>Add new pages to your marketplace</span> 
              </div>
              <div class="private-setting-switch">
                 <a href="#" class="btn-black-mdx" id = "showpreview">Preview</a>
                 <span  class="grey-btn btn_delete_act">Cancel</span>
                 <a href="#" class="save-btn" id="save">Save</a> 
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
                              <input class="form-control" type="text" name="pg_title"  id = "title" required  maxlength="65"/>
                              <!-- <span id ="titlespan">You have <span id = "titleleft">65</span> characters left.</span> -->
                           </div>
                        </div>  
                        
                        <div class="col-md-12">
                                       <div class="form-group ">
                                          <label class="">Web URL</label>
                                          <div class="pgcrtseo-weburlsec">
                                              <span id = "marketplaceURL"></span>
                                              <input  type="text" name="meta_weburl" id="metaurl"/>
                                          </div>        
                                       </div>
                                   </div>

                        <div class="col-md-12">
                          <label class="">Content</label> <br>
                          <textarea class = "ckeditor" name="editor1" id="editor1" ></textarea required>
                        </div>  
                        <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                <div class="panel-box">

                      <div class="pgcreate-frmarea  pgcrt-meta-seosec">
                            <h4 id = "seotitle">Meta Title of the SEO</h4>
                            <div class="pgcrt-meta-seobtn">
                                <span class="pgcrt-link-cstmseo">Edit</span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="seopg-link" id ="seolink">https://marketplace.arcadier.io/pages/meta-title-of-the-seo</div>  
                           <p id ="seodesc">This is the meta description of the seo the people can see when they find the site in the search engine</p>
                      </div>

                      <div class="pgcreate-frmarea  pgcrt-meta-seoeditsec hide">
                            <div class="pgcrt-meta-seoedit">
                               <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group ">
                                          <label class="">Meta Title </label>
                                          <input class="form-control" type="text" name="meta_title"  id="metatitle" maxlength="65" />
                                          <span id = "metatitlespan">You have <span id = "metatitleleft">65</span> characters left.</span>
                                       </div>
                                   </div>
                                   <div class="col-md-6 pgcrtseo-aplybtnsec">
                                        <span class="pgcrtseo-aplyllink" id="saveNew">Save</span>
                                   </div> 
                                   <div class="col-md-12">
                                       <div class="form-group ">
                                          <label class="">Meta Description </label>
                                          
                                          <textarea class="form-control" name="meta_desc" id="metadescs"  maxlength="300" style="display:none"; placeholder = "This is the meta description of the seo the people can see when they find the site in the search engine"></textarea>
                                          <textarea class="form-control" name="meta_desc" id="metadescs1"  maxlength="170" placeholder = "This is the meta description of the seo the people can see when they find the site in the search engine"></textarea>
                                          <span id = "metadescspan">You have <span id = "metaleft">170</span> characters left.</span>
                                     
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
                                    <input type="radio" value="0" name="opt_del" id="pg_avail_pub"  class="" id = "available">
                                    <label for="pg_avail_pub"><span>Publish</span></label>
                                  </div>
                            </div>

                            <div class="pgcreate-sbarcon pgfncyopt">
                                <div class="fancy-radio">
                                    <input type="radio" value="1" name="opt_del" id="pg_avail_hide"  class="" id = "hide">
                                    <label for="pg_avail_hide">Hide</label>
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
                                    <input type="radio" value="0" name="visible-to" id="visible-to1"  class="">
                                    <label for="visible-to1"><span>All users</span></label>
                                  </div>
                            </div>

                            <div class="pgcreate-sbarcon pgfncyopt">
                                <div class="fancy-radio">
                                    <input type="radio" value="1" name="visible-to" id="visible-to2"  class="">
                                    <label for="visible-to2">Merchants and Registered Buyers</label>
                                  </div>
                            </div>
                             <div class="pgcreate-sbarcon pgfncyopt">
                                <div class="fancy-radio">
                                    <input type="radio" value="2" name="visible-to" id="visible-to3"  class="">
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
   
    var editor =  CKEDITOR.replace( 'editor1', {
      // , items: [ 'Preview','Source']                            
    toolbar: [
    { name: 'document', groups: ['document', 'doctools' ] },
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: ['-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: ['-', 'SelectAll', '-'] },
    '/',
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-'] },
    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',  '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-'] },
    { name: 'links', items: [ 'Link', 'Unlink'] },
    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar','imageuploader'] },
    '/',
    { name: 'styles', items: ['Format', 'Font', 'FontSize' ] },
    { name: 'colors', items: [ 'TextColor', 'BGColor','youtube' ] },
]
// extraPlugins: 'imageuploader'
});  
// var editor2 = CKEDITOR.replace( 'metadescs', {
//               toolbar: []
//             } );


var textarea = document.getElementById("metadescs1");
textarea.addEventListener("input", function(){
    var maxlength = this.getAttribute("maxlength");
    var currentLength = this.value.length;

    if( currentLength >= maxlength ){
   
    }else{
      $('#metaleft').text(maxlength - currentLength);
      $('#metaleft').css('color','green');
       
    }
});


var textarea = document.getElementById("metatitle");
textarea.addEventListener("input", function(){
    var maxlength = this.getAttribute("maxlength");
    var currentLength = this.value.length;

    if( currentLength >= maxlength ){

    }else{
      $('#metatitleleft').text(maxlength - currentLength);
      $('#metatitleleft').css('color','green');
      
    }
});


var textarea = document.getElementById("title");
textarea.addEventListener("input", function(){
    var maxlength = this.getAttribute("maxlength");
    var currentLength = this.value.length;

    if( currentLength >= maxlength ){
  
    }else{
      $('#titleleft').text(maxlength - currentLength);
      $('#titleleft').css('color','green');
     
    }
});


$('#metatitle').blur(function() {
  $('#metatitlespan').hide();
});

$('#metatitle').focus(function() {
  $('#metatitlespan').show();
});


$('#metadescs1').blur(function() {
  $('#metadescspan').hide();
});

$('#metadescs1').focus(function() {
  $('#metadescspan').show();
});

function preview() {
 var data1 = CKEDITOR.instances.editor1.getData();
 var title =  $('#title').val();
 var url =  $('#path').val();

 var fullurl = url.concat('?pagetitle=',title,'&content=',data1);
 $('#showpreview').attr("target", target="_blank")
 $("#showpreview").attr("href", fullurl);
 
}


data2 = CKEDITOR.instances.editor1.getData();
        html=CKEDITOR.instances.editor1.getSnapshot();
        dom=document.createElement("DIV");
        dom.innerHTML=html;
        plain_text=(dom.textContent || dom.innerText);
        var res1 =  plain_text.charAt(plain_text.length-1);     
     
          meta =  $('#metadescs1');
          meta.text(plain_text);


        function GetContents1()
        {
        
      
        data2 = CKEDITOR.instances.editor1.getData();
        html=CKEDITOR.instances.editor1.getSnapshot();
        dom=document.createElement("DIV");
        dom.innerHTML=html;
        plain_text=(dom.textContent || dom.innerText);
       
          meta =  $('#metadescs1');
          meta.text(plain_text);
     
        }
        function GetContents2()
        {
          
        
        data2 = CKEDITOR.instances.editor1.getData();
        html=CKEDITOR.instances.editor1.getSnapshot();
        dom=document.createElement("DIV");
        dom.innerHTML=html;
        plain_text=(dom.textContent || dom.innerText);
       

          meta =  $('#metadescs1');
          meta.text(data2);
          var res =  plain_text.charAt(plain_text.length-1);     
        }

        editor.on('change', function(ev){ 
       
          var el =   document.getElementById("metadescs1");
          var text = $('#metadescs1').val();
          var max = el.attributes.maxLength.value;
          var currentLength = el.value.length;

          if (el.value.length >= max)
          {
            $('#metadescs1').val(text.substring(0,max));
          }else {
            $('#metaleft').text(max - currentLength);
            $('#metaleft').css('color','green');
            GetContents1();
            //GetContents2();
          }
          }); 
        
        CKEDITOR.config.removePlugins = 'elementspath';
     

          //TEST FUNCTION
          function getCharFromPos(editor)
{
   var sWord = '';
   var endPos = setCursorPos(editor);
   var sText  = editor.document.$.body.innerText;   
   
   while (endPos > 0)
   {
      var ch = sText.charAt( endPos );
      if (ch == ' ')
         break;
         
      sWord += ch;
      endPos--;
   }
         
   return sText.substring(endPos, 1+cursorPos.z);
}

function setCursorPos(editor)
{
   if (!editor)
      return;
         
   var objRange  = editor.document.$.selection.createRange();
   var sOldRange = objRange.text;
   var sTempStr = '%$#'

   //insert the sTempStr where the cursor is at
   objRange.text = sOldRange + sTempStr; objRange.moveStart('character', (0 - sOldRange.length - sTempStr.length));

   //save off the new string with sTempStr 
   var sNewText = editor.document.$.body.innerText; 
   console.log('editor ' + sNewText);
   //set the actual text value back to how it was
   objRange.text = sOldRange;

       // locate sTempStr  and get its position
   for (var i=0; i <= sNewText.length; i++) 
   {
      var sTemp = sNewText.substring(i, i + sTempStr.length);
      if (sTemp == sTempStr) 
      {
         var curPos  = (i - sOldRange.length);
         return curPos-1;
      }   
   }
   return 0;
}


    </script>

<script type="text/javascript">

     jQuery(document).ready(function() {

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

         jQuery('.btn_delete_act').click(function(){  
            jQuery('#DeleteCustomMethod').show();
            jQuery('#cover').show();
        });

        jQuery('#popup_btnconfirm').click(function(){  
            jQuery('#DeleteCustomMethod').hide();
            jQuery('#cover').hide();
        });

        jQuery('#popup_btnconfirm_cancel').click(function(){  
           // jQuery('#DeleteCustomMethod').hide();
           // jQuery('#cover').hide();
        });

        jQuery('#popup_btncancel,.close-popup').click(function(){  
            jQuery('#DeleteCustomMethod').hide();
            jQuery('#cover').hide();
        });

        //pre fill the meta title with the page title and replace the spaces with (-)
        $("#title").keyup(function(){
          title = $('#title').val();
          $("#metatitle").val($('#title').val());

          str = title.replace(/\s+/g, '-').toLowerCase();
          $("#metaurl").val(str);
        
        });
   
  function maxLength(el) {    
       if (!('maxLength' in el)) {
        var max = el.attributes.maxLength.value;
        el.onkeypress = function () {
            if (this.value.length >= max) {
       ;
            return false;
            } //
           
        };
    }
  }

  $("#metadescs1").on("focus", function(){
    var el =   document.getElementById("metadescs1");
          var text = $('#metadescs1').val();
          var max = el.attributes.maxLength.value;
    $(this).val(text.substring(0,max));
});
  
maxLength(document.getElementById("metadescs1"));

    }); 
</script> 
<script type="text/javascript" src="scripts/package.js"></script>
<!-- end footer --> 
