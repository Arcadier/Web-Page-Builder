(function ()
{
    var scriptSrc = document.currentScript.src;
    var re = /([a-f0-9]{8}(?:-[a-f0-9]{4}){3}-[a-f0-9]{12})/i;
    var packageId = re.exec(scriptSrc.toLowerCase())[1];


    $(document).ready(function ()
    {

         // page-home
     	if (document.body.className.includes('page-home')) {
         
        $('.more-menu li a').each(function () 
        {
            var link = $(this).attr('href');

            if (link.indexOf('/pages') >= 0) {
                var custdomain = window.location.href.replace('/#','');
                console.log(custdomain);
                var blogpage = link.split('/pages')[1]; 
                var url = custdomain + '/pages' + blogpage;
                $(this).attr('href',url);

            console.log(link);
            }
            });
       
       }
      
       })

})();