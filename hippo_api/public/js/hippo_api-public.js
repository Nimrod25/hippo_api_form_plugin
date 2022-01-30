$(document).on("submit","#hippo_form",function () {
    jQuery('form input[type="submit"]').val("Please wait.....");
    var data = $('#hippo_form').serializeArray();
       $.ajax({
          type: "POST",
          url: my_ajax_object.ajax_url,
          data: data,
          success: function(data) {
              
              var res = JSON.parse(data);
              if(res.hasOwnProperty("quote_premium")){
                var price = res.quote_premium;    
               var cur = new Intl.NumberFormat('en-US', {
                  style: 'currency',
                  currency: 'USD',
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                });
                price = cur.format(price);
                alert("Quote Premium: "+price);
               }else{
                   alert(res.errors[0].message);
                }
              
              jQuery('form input[type="submit"]').val("SUBMIT");
              //var obj = jQuery.parseJSON(data); if the dataType is not     specified as json uncomment this
            // do what ever you want with the server response
         },
        error: function(e) {
            console.log(e);
        }
    });

   event.preventDefault();
});