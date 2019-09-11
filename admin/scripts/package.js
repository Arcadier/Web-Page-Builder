(function() {
    var scriptSrc = document.currentScript.src;
   var urlss = window.location.href.toLowerCase();
    var packagePath = scriptSrc.replace('/scripts/package.js', '').trim();
    var indexPath = scriptSrc.replace('/scripts/package.js', '/index.php').trim();
    var pagelist = scriptSrc.replace('/scripts/package.js', '/pages_list.php').trim();
    var token = commonModule.getCookie('webapitoken');
    var re = /([a-f0-9]{8}(?:-[a-f0-9]{4}){3}-[a-f0-9]{12})/i;
    var packageId = re.exec(scriptSrc.toLowerCase())[1];
    var marketplace = scriptSrc.replace('/admin/plugins/'+ packageId +'/scripts/package.js', '/pages/').trim();
    var stylepath =  scriptSrc.replace('/admin/plugins/'+ packageId +'/scripts/package.js', '/user/plugins/'+ packageId +'/css/styles.css').trim();
    var customFieldPrefix = packageId.replace(/-/g, "");
    var userId = $('#userGuid').val();
    var isAvailable, isVisible, content, data1, data2, plain_text;
    var dom;
    var html;
    var preview_url =  $('#path').val();
    var preview_url_edit =  $('#urlpath').val();
    var timezone_offset_minutes = new Date().getTimezoneOffset();
    timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
    var pagedids;
    var strCount = 0;
    //run on creation page only
    if (urlss.indexOf('/create_page.php') >= 0) {
          setInterval(savePreview, 3000);
    }

    //run of edit page only
    if (urlss.indexOf('/edit_content.php') >= 0) {
         setInterval(savePreviewEdit, 3000);
    }

    function setTimezoneOffset(){
        var data = {'timezone':  timezone_offset_minutes };
         var apiUrl = packagePath + '/load_pages.php';
        $.ajax({
            url: apiUrl,          
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(result) {
            },
            error: function (jqXHR, status, err) {
            }
        });
    }
    function setTimezoneOffsetindex(){
        var data = {'timezone':  timezone_offset_minutes };
         var apiUrl = packagePath + '/pages_list.php';
        $.ajax({
            url: apiUrl,          
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(result) {
            },
            error: function (jqXHR, status, err) {
            }
        });
    }
    function savePageContent() {
        $('#save').addClass('disabled');
        
        data1 = CKEDITOR.instances.editor1.getData();
        var data = { 'userId': userId, 'title': $('#title').val(), 'content': data1, 'pageURL': marketplace + $('#metaurl').val(), 'metadesc' : $('#metadescs1').val(), 'visibility': isVisible, 'availability': isAvailable,'timezone':  timezone_offset_minutes , 'pageURLshort' : '/pages/' +  $('#metaurl').val(), 'stylesheet': stylepath };
         var apiUrl = packagePath + '/save_new_content.php';
        $.ajax({
            url: apiUrl,          
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(result) {
                toastr.success('Page Contents successfully saved.');
                $('#title').val('');
                $('#save').removeClass('disabled');
                 window.location.href = indexPath;
            },
            error: function (jqXHR, status, err) {
            }
        });
    }

    function savePreview(){
        data1 = CKEDITOR.instances.editor1.getData();
        var data = { 'userId': userId, 'title': $('#title').val(), 'page': data1};
        
        var apiUrl = packagePath + '/save_preview.php';
        $.ajax({
            url: apiUrl,          
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(result) {   
            },
            error: function (jqXHR, status, err) {
            }
        });
    }

    
    function savePreviewEdit() {
        data1 = CKEDITOR.instances.editor1.getData();
        var data = { 'userId': userId, 'title': $('#title').val(), 'page': data1};
        var apiUrl = packagePath + '/save_preview.php';
        $.ajax({
            url: apiUrl,          
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(result) {

              
            },
            error: function (jqXHR, status, err) {
            }
        });
    }
    function saveModifiedPageContent() {
        data1 = CKEDITOR.instances.editor1.getData();
        var data = { 'pageId' : $('#pageid').val(),'userId': userId, 'title': $('#title').val(), 'content': data1, 'pageURL': marketplace +  $('#metaurl').val(), 'metadesc': $('#metadesc').val(), 'visibility': isVisible, 'availability': isAvailable,'timezone':  timezone_offset_minutes, 'pageURLshort' :  '/pages/' + $('#metaurl').val() };
         var apiUrl = packagePath + '/save_modified_content.php';
        $.ajax({
            url: apiUrl,          
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(result) {
                toastr.success('Page Contents successfully updated.');
                $('#title').val('');
                window.location.href = indexPath;
            },
            error: function (jqXHR, status, err) {
            }
        });
    }

    function deletePage() {
        var data = { 'pageId' : pagedids,'userId': userId};
        console.log(pagedids);
         var apiUrl = packagePath + '/delete_content.php';
        $.ajax({
            url: apiUrl,          
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(result) {
                toastr.success('Page Content successfully deleted.');
                location.reload(); 
            },
            error: function (jqXHR, status, err) {
            }
        });
    }
 
    function getMarketplaceCustomFields(callback) {
        var apiUrl = '/api/v2/marketplaces'
        $.ajax({
            url: apiUrl,
            method: 'GET',
            contentType: 'application/json',
            success: function(result) {
                if (result) {
                    callback(result.CustomFields);
                }
            }
        });
    }

    $(document).ready(function() {

        $('.paging').css('margin','auto');

        if (urlss.indexOf('/create_page.php') >= 0) {
        if(isVisible == null || isAvailable == null){
        $('input:radio[name="opt_del"]').filter('[value="0"]').attr('checked', true);
        isAvailable = $("input[name='opt_del']:checked").val();
        $('input:radio[name="visible-to"]').filter('[value="0"]').attr('checked', true);
        isVisible = $("input[name='visible-to']:checked").val();
        }
       
     }
        var pathname = (window.location.pathname + window.location.search).toLowerCase();

        const index1 = '/admin/plugins/' + packageId;
        const index2 = '/admin/plugins/' + packageId + '/';
        const index3 = '/admin/plugins/' + packageId + '/index.php';
        if ( pathname == index1 ||  pathname == index2 ||  pathname == index3) {
            window.location = pagelist + '?tz=' + timezone_offset_minutes; 
        }
      
        //set the marketplace URL
        $('#marketplaceURL').text(marketplace);
        //check availability
            $('input:radio[name="opt_del"]').change(function() {
                isAvailable = $("input[name='opt_del']:checked").val();
                console.log(isAvailable);
                if(isAvailable){
                }
            });

         // check the visibilty
         $('input:radio[name="visible-to"]').change(function() {
            isVisible = $("input[name='visible-to']:checked").val();
            if(isVisible){
            }
         });
       //save the page contents
          $('#save').click(function() {
          
            validateMetadesc();

             if($("#title").val() == "" || data1 == "" || $('#metadescs1') == ""){ 
                 toastr.error('Please fill in empty fields.');
          
             }
            else if($("#metaurl").val() == "") {
                toastr.error('URL is required.');
             }else {
              
                savePageContent();
             }
         });
        //save modified page contents
          $('#edit').click(function() {

               if($("#title").val() == "" || data1 == "" || $('#metadesc') == ""){ 
                 console.log('true');
                 toastr.error('Please fill in empty fields.');
          
             }
            else if($("#metaurl").val() == "") {
                toastr.error('URL is required.');
             }else {
            saveModifiedPageContent();
             }
          });
        
          //delete the page contents
          $('#popup_btnconfirm').click(function() {
          
            pagedids = $('.record_id').val();
            deletePage();
            //
          });

          $('#showpreview').click(function() {
            $('#showpreview').attr("target", target="_blank")
            $("#showpreview").attr("href", preview_url);
         
          //
          });

          //preview EDIT
          $('#showpreviewEdit').click(function() {
            $('#showpreviewEdit').attr("target", target="_blank");
            $("#showpreviewEdit").attr("href", preview_url_edit);
             
           
            //
          });

          //cancel button
          $('#popup_btnconfirm_cancel').click(function() {
            window.location.href = indexPath;
          });
          
         //minimize button

         if (urlss.indexOf('/create_page.php') >= 0) {
         if($('.pgcrtseo-aplyllink').text() == 'Save') {
             
            // $('#editContent').click(function() {
               $('#saveNew').click(function() {
             
                hasTitle = 0;
                hasDesc = 0;
            if ($("#metatitle").val() == "") {
                hasTitle = 1;
                toastr.error('Meta Title is required.');
            }
            else if($('#metadescs1').val() == ""){
                hasDesc = 1;
                toastr.error('Meta  Description is required.');
           
            }
            else if (($("#metadescs1").val() == "" && $("#metatitle").val() == "")){
                toastr.error('Meta Title and Description is required.');
            }

            else {
              
                $('.pgcrt-meta-seosec').removeClass('hide');
                $('.pgcrt-meta-seoeditsec').addClass('hide');
                //handle the values of seo details here
                $("#seotitle").text($('#metatitle').val());  
                $('#seolink').text(marketplace +  $('#metaurl').val());
                $('#seodesc').text($("#metadescs1").val());
   
            }

          });
          }
        }
          //updating the text field for mete description
        if (urlss.indexOf('/edit_content.php') >= 0) {
            // setInterval(savePreviewEdit, 3000);
        
          if($('.pgcrtseo-aplyllink').text() == 'Save') {
               $('#editContent').click(function() {
            
                hasTitle = 0;
                hasDesc = 0;
            if ($("#metatitle").val() == "") {
                hasTitle = 1;
                toastr.error('Meta Title is required.');
            }
            else if($('#metadesc').val() == ""){
                hasDesc = 1;
                toastr.error('Meta  Description is required.');
           
            }
            else if(($("#metadesc").val() == "" && $("#metatitle").val() == "")){
                toastr.error('Meta Title and Description is required.');
            }

            else {
                $('.pgcrt-meta-seosec').removeClass('hide');
                $('.pgcrt-meta-seoeditsec').addClass('hide');
                //handle the values of seo details here
                $("#seotitle").text($('#metatitle').val());  
                $('#seolink').text(marketplace +  $('#metaurl').val());
                $('#seodesc').text($('#metadesc').val());
            }

          });
          }
        }

      function validateMetadesc(){
        var el =   document.getElementById("metadescs1");
        var text = $('#metadescs1').val();
        var max = el.attributes.maxLength.value;
        $('#metadescs1').val(text.substring(0,max));
      }


        //EDIT SEO FOR UPDATE PAGE
        $('#metaurl').bind('keydown', function (event) {
            switch (event.keyCode) {
                case 8:  // Backspace
                case 9:  // Tab
                case 13: // Enter
                case 37: // Left
                case 38: // Up
                case 39: // Right
                case 40: // Down
                break;
                default:
                var regex = new RegExp("^[A-Za-z0-9-]+$");
                var key = event.key;
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
                break;
            }
    });
    


        $('#title').bind('keydown', function (event) {
            switch (event.keyCode) {
                case 8:  // Backspace
                case 9:  // Tab
                case 13: // Enter
                case 37: // Left
                case 38: // Up
                case 39: // Right
                case 40: // Down
                break;
                default:
                var regex = new RegExp ("^[a-zA-Z0-9_.!',?() ]*$");
                var key = event.key;
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
                break;
            }
    });


        $(function(){

            $( "#title" ).bind( 'paste',function()
            {
                setTimeout(function()
                { 
                   var data= $( '#title' ).val() ;
                   var dataFull = data.replace(/[^\w\s]/gi, '');
                   $( '#title' ).val(dataFull);
                });
         
             });
         });

         $(function(){

            $( "#metaurl" ).bind( 'paste',function()
            {
                setTimeout(function()
                { 
               
                   var data= $( '#metaurl' ).val() ;
                   var dataFull1 = data.replace(/[^\w\s]/gi, '');
                   $( '#metaurl' ).val(dataFull1);
                });
         
             });
         });
    });
})();