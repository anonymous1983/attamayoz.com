        {$_old_body_bg = $POS_BGCOLOR}
        {$_body_background = 'ffffff'}
        {if $_COOKIE.body_background_cookie}
            {$_body_background = $_COOKIE.body_background_cookie}
        {/if}

        {$_old_main_color = $POS_MAINCOLOR}
        {$_main_color = '446CB3'}
        {if $_COOKIE.main_color_cookie}
            {$_link_color = $_COOKIE.main_color_cookie}
        {/if}
		
        {$_old_link_color = $POS_LINKCOLOR}
        {$_link_color = 'c83a3a'}
        {if $_COOKIE.link_color_cookie}
            {$_link_color = $_COOKIE.link_color_cookie}
        {/if}

        <div class="pos-demo-wrap">
		<h2 class="pos-demo-title">Theme Options</h2>
		<div class="pos-demo-option">
			<div class="cl-wrapper">
				<div class="cl-container">
					<div class="cl-table">
						<div class="cl-tr cl-tr-style">
							<div class="cl-td-l cl-td-layout cl-td-layout1"><a href="#" id="teal" title="skin 1"><span></span>{l s='Skin 1'}</a></div>
							<div class="cl-td-r cl-td-layout cl-td-layout2"><a href="#" id="blue" title="skin 2"><span></span>{l s='Skin 2'}</a></div>
						</div>
						<div class="cl-tr cl-tr-style">
							<div class="cl-td-r cl-td-layout cl-td-layout3"><a href="#" id="green" title="Skin 3"><span></span>{l s='Skin 3'}</a></div>
							<div class="cl-td-r cl-td-layout cl-td-layout4"><a href="#" id="brown" title="Skin 4"><span></span>{l s='Skin 4'}</a></div>
						</div>
						<div class="cl-tr cl-tr-style">
							<div class="cl-td-r cl-td-layout cl-td-layout5"><a href="#" id="red" title="Skin 5"><span></span>{l s='Skin 5'}</a></div>
							<div class="cl-td-r cl-td-layout cl-td-layout6"><a href="#" id="orange" title="Skin 6"><span></span>{l s='Skin 6'}</a></div>
						</div>
					</div> 	
                </div>		
			</div>
		</div>
		<div class="control inactive"><a href="javascript:void(0)"></a></div>
		<script type="text/javascript">
//			$(document).ready( function(){ldelim}
				$('.control').click(function(){ldelim}
					if($(this).hasClass('inactive')) {ldelim}
						$(this).removeClass('inactive');
						$(this).addClass('active');
						$('.pos-demo-wrap').animate({ldelim}left:'0'{rdelim}, 500);
					{rdelim} else {ldelim}
						$(this).addClass('inactive');
						$('.pos-demo-wrap').animate({ldelim}left:'-250px'{rdelim}, 500);
					{rdelim}
				{rdelim});
//			{rdelim});
		</script>
	</div>
<script type="text/javascript">
//<![CDATA[  
    $('#bodyBackgroundColor,#mainColor, #linkColor').each(function() {ldelim}
        var $el = $(this);
        /* set time */
        var date = new Date();
        date.setTime(date.getTime() + (1440 * 60 * 1000));
    
        $el.ColorPicker({ldelim}
            color: '#0000ff',
            onChange: function (hsb, hex, rgb) {ldelim}
    
                $el.find('div').css('backgroundColor', '#' + hex);
                switch ($el.attr("id")) {ldelim}			
					
                  case 'bodyBackgroundColor' :
                    $("body").css('backgroundColor', '#' + hex);
                    // set cookie
                    
                    $.cookie('body_background_cookie', hex , {ldelim} expires: date {rdelim});
                    break;
				// main color
				  case 'mainColor' :
					$('<style type="text/css">.pos-newproductslider-container .actions, .products-grid .actions, .pos-brand-slider-contain .flex-direction-nav a:hover, .pos-footer-static-container, .pos-nav-mobile-container, .pos-nav-container, .content-sample-block .block1 img, .productpage-sample-block .block2 img  { background-color:#'+hex+'}</style>').appendTo('head');
					
										$('<style type="text/css">.product-view button.btn-cart:hover span { background-color:#'+hex+' !important}</style>').appendTo('head');

					
					$('<style type="text/css">a:hover, .products-grid .product-name a:hover, .product-name a:hover { color:#'+hex+'}</style>').appendTo('head');
					
				  // set cookie
				  $.cookie('main_color_cookie', hex , {ldelim} expires: date {rdelim});
				  break;	
				
                  case 'linkColor' :
                    //$("body a").css('color', '#' + hex);
					$('<style type="text/css"> button.button span, .pager .sort-by .select-sort-by:before, .pager .sort-by select, .pager .limiter .select-limiter:before, .pager .limiter select, .toolbar, .top-cart-title .title, .ui-widget-header, #search_price, .block-subscribe .actions button.button span, .opc .active .step-title .number, .product-tabs a:hover, .product-tabs li.active a:hover, #back-top, .pos-featuredproductslider-container, .pos-featuredproductslider-container .flexslider .flex-next:hover, .pos-featuredproductslider-container .flexslider .flex-prev:hover,  .pos-newproductslider-container, .pos-newproductslider-container .flexslider .flex-next:hover, .pos-newproductslider-container .flexslider .flex-prev:hover, .pos-brand-slider-contain .flexslider .flex-next:hover, .pos-brand-slider-contain .flexslider .flex-prev:hover, .pos-relatedslider-container .flexslider .flex-next:hover, .pos-relatedslider-container .flexslider .flex-prev:hover, .pos-upsellslider-container .flexslider .flex-next:hover, .pos-upsellslider-container .flexslider .flex-prev:hover, .pos-thumbnail-container .flexslider .flex-next:hover, .pos-thumbnail-container .flexslider .flex-prev:hover, .product-tabs li.active a, .product-tabs li.active a:hover, .pos-banner7-container .flex-control-paging li a:hover, .pos-banner7-container .flex-control-paging li a.flex-active, .nivo-controlNav a:hover, .nivo-controlNav a.active { background-color:#'+hex+'}</style>').appendTo('head');
					
					$('<style type="text/css"> .ui-widget-header { background-color:#'+hex+' !important}</style>').appendTo('head');
					
					$('<style type="text/css"> a, button.btn-cart:hover span, .fieldset .legend, .breadcrumbs li a:hover, .breadcrumbs li strong, .link-wishlist:hover, .link-compare:hover, .pos-header-container .toplink .links a:hover, .header-static span, .block-account .block-content li a:hover, .block-account .block-content li.current, .regular-price .price, .special-price .price, .email-friend a:hover, .product-name a:hover, .opc .active .step-title h2, .footer-static li a:hover, .parentMenu .block-title:hover, #pt_menu_link ul li a.act, #pt_menu_link ul li a:hover, div.pt_menu.act a, div.pt_menu.active .parentMenu a, div.pt_menu.active .parentMenu .block-title, div.pt_menu a:hover, .pt_custommenu div.popup a:hover, .multiple-checkout h3, .multiple-checkout h4, .product-tabs li.active a, .multiple-checkout .box h2, .multiple-checkout .place-order .grand-total .price, .top-cart-contain .price, #shopping_cart a, .navbar .nav > li > a, .nav-item a, .nav-item a.login, .nav-item span { color:#'+hex+'}</style>').appendTo('head');
					
					$('<style type="text/css">  { color:#'+hex+' !important}</style>').appendTo('head');
					$('<style type="text/css"> .fieldset .legend, .page-title, .pager .pages a, .block .block-title, .block-layered-nav dt, .opc .active .step-title .number, .box-account .box-head , .itemMenu a.level1 span, .pos-featuredproductslider-container .featuredproductslider-item, .pos-newproductslider-container .newproductslider-item, .pos-relatedslider-container .related-product-title, .product-tabs li.active a{ border-color:#'+hex+'}</style>').appendTo('head');
					
                    // set cookie
                    $.cookie('link_color_cookie', hex , {ldelim} expires: date {rdelim});
                    break;			
				
                {rdelim}
            {rdelim}
        {rdelim});
    {rdelim});
    /* set time */
    var date = new Date();
    date.setTime(date.getTime() + (1440 * 60 * 1000));
	
	
		// set default background image
		{$_old_bd_img = ''}
		{$_bd_img = ''}
		{if $_COOKIE.body_image_cookie}
			{$_bd_img = $_COOKIE.body_image_cookie}
		{/if}
	
		
	//$(document).ready(function(){ldelim}
		
		//load selected font
		$("#select-fontselector option").filter(function() {ldelim}
			//may want to use $.trim in here
			return $(this).text() == $.cookie('font_cookie'); 
		{rdelim}).attr('selected', true);
		//change font
		$(function(){ldelim}
			fontSelect=$("#select-fontselector");
			fontUpdate=function(){ldelim}
				curFont=$("#select-fontselector").val();
				$(".page-title h1, .page-title h2, .block .block-title strong, .block-right-static .block-title h3, .block-subscribe-right .block-title h3, .pos-mostviewed-product-title h2, .pos-upsellslider-container .product-name, .pos-newproductslider-container .product-name, .products-grid .product-name, .pos-featured-product-title h2, .pos-newproductslider-title h2, .products-list .product-name, .product-collateral h2, .product-view .product-shop .product-name h1, .product-view .box-up-sell h2, .footer-freeshipping h3, .footer-subscribe .form-subscribe-header h4, .pos-footer-static .footer-static-title h3, .product-tabs a, .wine_menu a, .fish_menu a, .wine_menu ul li a ").css({ldelim} fontFamily: curFont {rdelim});
				
			{rdelim}
			fontSelect.change(function(){ldelim}
				fontUpdate();
			{rdelim}).keyup(function(){ldelim}
				fontUpdate();
			{rdelim}).keydown(function(){ldelim}
				fontUpdate();
			{rdelim});
			
			$("#select-fontselector").trigger("change");
		{rdelim})
		
		$('#select-fontselector').change(function() {ldelim}
			$.cookie('font_cookie', $(this).val(), {ldelim} expires: date {rdelim});
		{rdelim});
		$(".page-title h1, .page-title h2, .block .block-title strong, .block-right-static .block-title h3, .block-subscribe-right .block-title h3, .pos-mostviewed-product-title h2, .pos-upsellslider-container .product-name, .pos-newproductslider-container .product-name, .products-grid .product-name, .pos-featured-product-title h2, .pos-newproductslider-title h2, .products-list .product-name, .product-collateral h2, .product-view .product-shop .product-name h1, .product-view .box-up-sell h2, .footer-freeshipping h3, .footer-subscribe .form-subscribe-header h4, .pos-footer-static .footer-static-title h3, .product-tabs a, .wine_menu a, .fish_menu a, .wine_menu ul li a").css({ldelim} fontFamily: $.cookie('font_cookie') {rdelim}); 
		
		
		//set cookie
		$("body").css('backgroundColor', '#' + $.cookie('body_background_cookie'));
		$("body").css('background-image', $.cookie('body_image_cookie'));
		$("body").css('background-repeat','repeat');
		
		// main color

		$('<style type="text/css">.pos-newproductslider-container .actions, .products-grid .actions, .pos-brand-slider-contain .flex-direction-nav a:hover, .pos-footer-static-container, .pos-nav-mobile-container, .pos-nav-container, .content-sample-block .block1 img, .productpage-sample-block .block2 img  { background-color:#'+$.cookie('main_color_cookie')+'}</style>').appendTo('head');
		
							$('<style type="text/css">.product-view button.btn-cart:hover span { background-color:#'+$.cookie('main_color_cookie')+' !important}</style>').appendTo('head');

		
		$('<style type="text/css">a:hover, .products-grid .product-name a:hover, .product-name a:hover { color:#'+$.cookie('main_color_cookie')+'}</style>').appendTo('head');
					
		
		//link color
		$('<style type="text/css"> button.button span, .pager .sort-by .select-sort-by:before, .pager .sort-by select, .pager .limiter .select-limiter:before, .pager .limiter select, .toolbar, .top-cart-title .title, .ui-widget-header, #search_price, .block-subscribe .actions button.button span, .opc .active .step-title .number, .product-tabs a:hover, .product-tabs li.active a:hover, #back-top, .pos-featuredproductslider-container, .pos-featuredproductslider-container .flexslider .flex-next:hover, .pos-featuredproductslider-container .flexslider .flex-prev:hover,  .pos-newproductslider-container, .pos-newproductslider-container .flexslider .flex-next:hover, .pos-newproductslider-container .flexslider .flex-prev:hover, .pos-brand-slider-contain .flexslider .flex-next:hover, .pos-brand-slider-contain .flexslider .flex-prev:hover, .pos-relatedslider-container .flexslider .flex-next:hover, .pos-relatedslider-container .flexslider .flex-prev:hover, .pos-upsellslider-container .flexslider .flex-next:hover, .pos-upsellslider-container .flexslider .flex-prev:hover, .pos-thumbnail-container .flexslider .flex-next:hover, .pos-thumbnail-container .flexslider .flex-prev:hover, .product-tabs li.active a, .product-tabs li.active a:hover, .pos-banner7-container .flex-control-paging li a:hover, .pos-banner7-container .flex-control-paging li a.flex-active, .nivo-controlNav a:hover, .nivo-controlNav a.active { background-color:#'+$.cookie('link_color_cookie')+'}</style>').appendTo('head');
		
		
		
		$('<style type="text/css"> .ui-widget-header { background-color:#'+$.cookie('link_color_cookie')+' !important}</style>').appendTo('head');
		
		
		
		$('<style type="text/css"> a, button.btn-cart:hover span, .fieldset .legend, .breadcrumbs li a:hover, .breadcrumbs li strong, .link-wishlist:hover, .link-compare:hover, .pos-header-container .toplink .links a:hover, .header-static span, .block-account .block-content li a:hover, .block-account .block-content li.current, .regular-price .price, .special-price .price, .email-friend a:hover, .product-name a:hover, .opc .active .step-title h2, .footer-static li a:hover, .parentMenu .block-title:hover, #pt_menu_link ul li a.act, #pt_menu_link ul li a:hover, div.pt_menu.act a, div.pt_menu.active .parentMenu a, div.pt_menu.active .parentMenu .block-title, div.pt_menu a:hover, .pt_custommenu div.popup a:hover, .checkout-progress li.active, .multiple-checkout h3, .multiple-checkout h4, .multiple-checkout .box h2, .multiple-checkout .place-order .grand-total .price, .top-cart-contain .price, #shopping_cart a, .navbar .nav > li > a, .nav-item a, .nav-item a.login, .nav-item span { color:#'+$.cookie('link_color_cookie')+'}</style>').appendTo('head');
		
		
		
		$('<style type="text/css"> { color:#'+$.cookie('link_color_cookie')+' !important}</style>').appendTo('head');
		
		
		
		$('<style type="text/css"> .fieldset .legend, .page-title, .pager .pages a, .block .block-title, .block-layered-nav dt, .opc .active .step-title .number, .box-account .box-head , .itemMenu a.level1 span, .pos-featuredproductslider-container .featuredproductslider-item, .pos-newproductslider-container .newproductslider-item, .pos-relatedslider-container .related-product-title, .checkout-progress li.active { border-color:#'+$.cookie('link_color_cookie')+'}</style>').appendTo('head');
		
                //theme color
                $('<link rel="stylesheet" type="text/css" href="'+$.cookie('theme_color_cookie')+'" />').appendTo('head');
                
                
                //set theme color cookie
                $('.cl-td-layout a').click(function(){ldelim}
                    $('<link rel="stylesheet" type="text/css" href="{$PS_BASE_URL}{$PS_BASE_URI}themes/{$POS_THEMENAME}/css/global_'+this.id+'.css" />').appendTo('head');
                    $.cookie('theme_color_cookie', '{$PS_BASE_URL}{$PS_BASE_URI}themes/{$POS_THEMENAME}/css/global_'+this.id+'.css', {ldelim} expires: date {rdelim});
                {rdelim});
		//set background image
		$('.cl-pattern div').click(function(){ldelim}
			$("body").css('background-image', 'url({$PS_BASE_URL}{$PS_BASE_URI}modules/{$POS_MODULENAME}/views/templates/front/colortool/images/pattern/'+this.id+'.png)');
			$("body").css('background-repeat','repeat');
			$.cookie('body_image_cookie', 'url({$PS_BASE_URL}{$PS_BASE_URI}modules/{$POS_MODULENAME}/views/templates/front/colortool/images/pattern/'+this.id+'.png)', {ldelim} expires: date {rdelim});
		{rdelim});
	
		//set cookie for theme color
//		var cl = $(".cl-row-themeskin");
//		cl.find("a").each(function() {ldelim}
//			$(this).click(function(){ldelim}
//				$.cookie('style_color', $(this).attr('title') , {ldelim} expires: date {rdelim});
//				location.reload();
//			{rdelim});
//		{rdelim});
	//{rdelim});
		
	
    //reset button
    $('.cl-reset').click(function(){ldelim}
		$.cookie('font_cookie','');
		$.cookie('main_color_cookie','');
		$.cookie('link_color_cookie','');
		$.cookie('theme_color_cookie','');
        $.cookie('body_image_cookie','');	
		$("body").css('background-image', 'url({$PS_BASE_URL}{$PS_BASE_URI}modules/{$POS_MODULENAME}/views/templates/front/colortool/images/pattern/{$_old_bd_img})');
		
        $.cookie('body_background_cookie','');
        $("body").css('backgroundColor', '#{$_old_body_bg}');
		location.reload();
    {rdelim});
//]]>
</script>