
<div class="pos-new-product">
	<div class="pos-new-product-title"><h2>{l s='New Product'}</h2></div>
	{if count($products)>1}
		<ul class="bxslider">			
			{foreach from=$products item=product name=posNewProducts}
				<li class="newproductslider-item ajax_block_product {if $smarty.foreach.posNewProducts.first}first_item{elseif $smarty.foreach.posNewProducts.last}last_item{else}item{/if} {if $smarty.foreach.posNewProducts.iteration%$nbItemsPerLine == 0}last_item_of_line{elseif $smarty.foreach.posNewProducts.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.posNewProducts.iteration > ($smarty.foreach.posNewProducts.total - $totModulo)}last_line{/if}">
					<a href="{$product.link|escape:'html'}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'pos_product')|escape:'html'}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product.name|escape:html:'UTF-8'}" />{if isset($product.new) && $product.new == 1}<span class="new">{l s='New' mod='posnewproduct'}</span>{/if}</a>
					<h5 class="s_title_block"><a href="{$product.link|escape:'html'}" title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
                                        {if $slideOptions.show_des ==1 }
                                            <div class="product_desc"><a href="{$product.link|escape:'html'}" title="{l s='More' mod='posnewproduct'}">{$product.description_short|strip_tags|truncate:65:'...'}</a></div>
                                        {/if}
					<div>
                                           <!-- <a class="lnk_more" href="{$product.link|escape:'html'}" title="{l s='View' mod='posnewproduct'}">{l s='View' mod='posnewproduct'}</a>-->
                                            {if $slideOptions.show_price ==1 }                                            
                                            {if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<p class="price_container"><span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></p>{else}<div style="height:21px;"></div>{/if}
                                            {/if}
                                            {if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
                                                    {if ($product.quantity > 0 OR $product.allow_oosp)}
                                                    {if $slideOptions.show_addtocart ==1 }
                                                        <a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart')|escape:'html'}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='posnewproduct'}">{l s='Add to cart' mod='posnewproduct'}</a>
                                                    {/if}
                                                    {else}
                                                    {if $slideOptions.show_addtocart ==1 }
                                                        <span class="exclusive">{l s='Add to cart' mod='posnewproduct'}</span>
                                                    {/if}
                                                    {/if}
                                            {else}
                                                    <div style="height:23px;"></div>
                                            {/if}
					</div>
				</li>
			{/foreach}
			
		</ul>

	{else}
	<p class="warning">{l s='No products for this new products.'}</p>
	{/if}
		<script type="text/javascript">
		  $('.pos-new-product .bxslider').bxSlider({
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
		 
</div>
