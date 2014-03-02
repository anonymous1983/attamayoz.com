<script type='text/javascript'>
//<![CDATA[

function setCookie(c_name,value,exdays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

$(document).ready(function() {
         var mode_product = '{$product_mode}';
         var modeButton = '<div id="view_as">';
            if(mode_product == 'grid') {
                modeButton += '<div class="switch_mode products_left_grid_button active"><span class="products_grid_button_id">{l s="Grid"}</span></div>'
            } else {
                modeButton += '<div class="switch_mode products_left_grid_button"><span class="products_grid_button_id">{l s="Grid"}</span></div>'
            }
            if(mode_product == 'list') {
                modeButton += '<div class="switch_mode products_right_grid_button active"><span class="products_list_button_id">{l s="List"}</span></div>'
            } else {
                modeButton += '<div class="switch_mode products_right_grid_button"><span class="products_list_button_id">{l s="List"}</span></div>'
            }
            modeButton += '</div>';

         var selectMode = '<select name ="switch_mode_product" class = "switch_mode_product">';
             if(mode_product == 'list') {
                selectMode += '<option value="list" selected ="selected">{l s="List"}</option>';
             } else {
                selectMode += '<option value="list">{l s="List"}</option>';
             }
             if(mode_product == 'grid') {
                selectMode += '<option value="grid" selected = "selected">{l s="Grid"}</option>';
             } else {
                selectMode += '<option value="grid">{l s="Grid"}</option>';
             }
             selectMode +='</select>';

    
         $('.sortPagiBar .mode-view').append(modeButton);
         //$('.content_sortPagiBar').append(selectMode);
         $('.switch_mode_product').bind('change', function() {
            var url = window.location.href;
            if(mode_product!=""){
                var mode = $(this).val();
             
                if(mode=='grid'){
                     setCookie('product_mode', 'grid',99999);  
                        location.reload();
                }
                if(mode=='list'){
                     
                     setCookie('product_mode', 'list',99999);  
                       location.reload();
                }

            }
          
         });
      
	$('.products_left_grid_button').bind('click', function(){
                //grid
                setCookie('product_mode', 'grid',99999);  
                //window.location.href = location.href;
				 location.reload();
  
	});
	$('.products_right_grid_button').bind('click', function(){
                //list
             setCookie('product_mode', 'list',99999);  
               //window.location.href = location.href;
			    location.reload();
  	});
});
//]]>
</script>

