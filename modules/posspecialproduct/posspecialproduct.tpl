<div class="pos-special-product">
	<div class="pos-special-product-title">{l s ='Special Product'}</div>
		<ul class="bxslider" >
			{foreach from=$products item=product name=products}
                            <li class="ajax_block_product {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if} {if $smarty.foreach.products.index % 2}alternate_item{else}item{/if} clearfix">
				<div class="item-inner">
                                            <a href="{$product.link|escape:'htmlall':'UTF-8'}" class="product_img_link" title="{$product.name|escape:'htmlall':'UTF-8'}">
                                                    <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'pos_product')|escape:'html'}" alt="{$product.legend|escape:'htmlall':'UTF-8'}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} />
                                            </a>
					    {if $slideOptions.show_price ==1 }  
                                            
                                            {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
                                            <div class="content_price">
						 {if $product.specific_prices}
              {assign var='specific_prices' value=$product.specific_prices}
              {if $specific_prices.reduction_type == 'percentage' && ($specific_prices.from == $specific_prices.to OR ($smarty.now|date_format:'%Y-%m-%d %H:%M:%S' <= $specific_prices.to && $smarty.now|date_format:'%Y-%m-%d %H:%M:%S' >= $specific_prices.from))}
               <span class="reduction"><span>-{$specific_prices.reduction*100|floatval}%</span></span>
              {/if}
             {/if} 
             
                                                    {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}<span class="special-price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span> {/if}
						    <span class="old-price">{if !$priceDisplay}{displayWtPrice p=$product.price_without_reduction}{else}{displayWtPrice  p={Tools::ps_round($product['price_without_reduction'], 2)} }{/if}</span>
                                                   
                                            </div>
                                            {/if}
                                            {/if}
                                            <h3>{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}<a class="product-name" href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h3>
                                            {if $slideOptions.show_des ==1 }
                                                 <p class="product_desc"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}" >{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}</a></p>
                                            {/if}
                                            
                                               {if $slideOptions.show_addtocart ==1 }
                                            {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
                                                    {if ($product.allow_oosp || $product.quantity > 0)}
                                                            {if isset($static_token)}
                                                                    <a class="button ajax_add_to_cart_button exclusive" rel="ajax_id_product_{$product.id_product|intval}" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html'}" title="{l s='Add to cart'}"><span></span>{l s='Add to cart'}</a>
                                                            {else}
                                                                    <a class="button ajax_add_to_cart_button exclusive" rel="ajax_id_product_{$product.id_product|intval}" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}", false)|escape:'html'}" title="{l s='Add to cart'}"><span></span>{l s='Add to cart'}</a>
                                                            {/if}						
                                                    {else}
                                                            <span class="exclusive"><span></span>{l s='Add to cart'}</span><br />
                                                    {/if}
                                            {/if}
                                            {/if}
				</div>
                            </li>
	{/foreach}
		</ul>
</div>
		<script type="text/javascript">
		  $('.pos-special-product .bxslider').bxSlider({
            auto: {if $slideOptions.auto_slide != 1}{$slideOptions.auto_slide}{else}1{/if},
            slideWidth:{if $slideOptions.width_item != ''}{$slideOptions.width_item}{else}250{/if},
			slideMargin: 20,
			minSlides: {if $slideOptions.min_item != ''}{$slideOptions.min_item}{else}3{/if},
			maxSlides: {if $slideOptions.max_item != ''}{$slideOptions.max_item}{else}8{/if},
			speed:  {if $slideOptions.speed_slide != ''}{$slideOptions.speed_slide}{else}5000{/if},
			pause: {if $slideOptions.a_speed != ''}{$slideOptions.a_speed}{else}1000{/if},
			controls: {if $slideOptions.show_nexback != 0}{$slideOptions.show_nexback}{else}false{/if},
            pager: {if $slideOptions.show_control != 0}{$slideOptions.show_control}{else}false{/if},
		});
	</script>