<script type='text/javascript'>
//<![CDATA[

function setCookie1(c_name,value,exdays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}
function setCookie(c_name, value, expiredays) {
	var exdate = new Date();
	exdate.setTime(exdate.getTime() + (expiredays * 86400000));

	document.cookie= c_name + "=" + escape(value) + ((expiredays==null) ? "" : ";expires=" + exdate.toUTCString());
}
function getCookie(c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
}

$(document).ready(function() {
		 setCookie('product_mode', 'grid',1);  
         var mode_product = '{$product_mode}';
	 var page_name = '{$page_name}';
         var modeButton = '<div id="view_as">';
            if(mode_product == 'grid') {
                modeButton += '<div class="switch_mode products_left_grid_button active"><span class="products_grid_button_id">{l s='Grid' mod='posmodeproduct'}</span></div>'
            } else {
                modeButton += '<div class="switch_mode products_left_grid_button"><span class="products_grid_button_id">{l s='Grid' mod='posmodeproduct'}</span></div>'
            }
            if(mode_product == 'list') {
                modeButton += '<div class="switch_mode products_right_grid_button active"><span class="products_list_button_id">{l s='List' mod='posmodeproduct'}</span></div>'
            } else {
                modeButton += '<div class="switch_mode products_right_grid_button"><span class="products_list_button_id">{l s='List' mod='posmodeproduct'}</span></div>'
            }
            modeButton += '</div>';
			
			var modeP = getCookie('product_mode');
			/*if (typeof(modeP) == "undefined")  {
				 setCookie('product_mode', 'grid',1);  
			}*/

         var selectMode = '<select name ="switch_mode_product" class = "switch_mode_product">';
             if(mode_product == 'list') {
                selectMode += '<option value="list" selected ="selected">{l s='List' mod='posmodeproduct'}</option>';
             } else {
                selectMode += '<option value="list">{l s='List' mod='posmodeproduct'}</option>';
             }
             if(mode_product == 'grid') {
                selectMode += '<option value="grid" selected = "selected">{l s='Grid' mod='posmodeproduct'}</option>';
             } else {
                selectMode += '<option value="grid">{l s='Grid' mod='posmodeproduct'}</option>';
             }
             selectMode +='</select>';

    
         //$('.content_sortPagiBar .product_mode_view').append(modeButton);
		 $('.sortPagiBar .mode-view').append(modeButton);
         //$('.content_sortPagiBar').append(selectMode);
		 
         $('.switch_mode_product').bind('change', function() {
            var url = window.location.href;
            if(mode_product!=""){
                var mode = $(this).val();
             
                if(mode=='grid'){
                        setCookie('product_mode', 'grid',1);  
                        location.reload();
                }
                if(mode=='list'){
                     
                     setCookie('product_mode', 'list',1);  
                       location.reload();
                }
			
            }
          
         });
      
	$('.products_left_grid_button').bind('click', function(){
				$('.products_right_grid_button').removeClass('active');
				$(this).addClass('active');
                //grid
                setCookie('product_mode', 'grid',1);
		if(page_name =='search') {
		    location.reload();
		} else {
		     reloadContent();
		}
  
	});
	
	$('.products_right_grid_button').bind('click', function(){
			$('.products_left_grid_button').removeClass('active');
			$(this).addClass('active');
             //list
             setCookie('product_mode', 'list',1);
	     if(page_name =='search') {
		    location.reload();
		} else {
		     reloadContent();
		}
			

  	});
});
//]]>
</script>

