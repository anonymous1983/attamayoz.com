{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{if count($categoryProducts) > 0 && $categoryProducts !== false}
<div class="clearfix blockposproductcategory">
	<h2 class="posproductcategory_h2">{$categoryProducts|@count} {l s='other products in the same category:' mod='posproductcategory'}</h2>
	<div id="{if count($categoryProducts) > 5}posproductcategory{else}posproductcategory_noscroll{/if}">
	{if count($categoryProducts) > 5}<a id="posproductcategory_scroll_left" title="{l s='Previous' mod='posproductcategory'}" href="javascript:{ldelim}{rdelim}">{l s='Previous' mod='posproductcategory'}</a>{/if}
	<div id="posproductcategory_list">
                 	<ul class="bxslider">	
                            {foreach from=$categoryProducts item='categoryProduct' name=categoryProduct}
                                   <li >
                                        <a href="{$link->getProductLink($categoryProduct.id_product, $categoryProduct.link_rewrite, $categoryProduct.category, $categoryProduct.ean13)}" class="lnk_img" title="{$categoryProduct.name|htmlspecialchars}"><img src="{$link->getImageLink($categoryProduct.link_rewrite, $categoryProduct.id_image, 'medium_default')|escape:'html'}" alt="{$categoryProduct.name|htmlspecialchars}" /></a>
                                        <p class="product_name">
                                                <a href="{$link->getProductLink($categoryProduct.id_product, $categoryProduct.link_rewrite, $categoryProduct.category, $categoryProduct.ean13)|escape:'html'}" title="{$categoryProduct.name|htmlspecialchars}">{$categoryProduct.name|truncate:14:'...'|escape:'htmlall':'UTF-8'}</a>
                                        </p>
                                        {if $slideOptions.show_des ==1 }
                                            <div class="product_desc"><a href="{$categoryProduct.link|escape:'html'}" title="{l s='More' mod='posproductcate'}">{$categoryProduct.description_short|strip_tags|truncate:65:'...'}</a></div>
                                        {/if}

                                        {if $slideOptions.show_price == 1 AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
                                        <p class="price_display">
                                                <span class="price">{convertPrice price=$categoryProduct.displayed_price}</span>
                                        </p>
                                        {else}
                                        <br />
                                        {/if}
                                        {if ($categoryProduct.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $categoryProduct.available_for_order AND !isset($restricted_country_mode) AND $categoryProduct.minimal_quantity == 1 AND $categoryProduct.customizable != 2 AND !$PS_CATALOG_MODE}
                                                        {if ($categoryProduct.quantity > 0 OR $categoryProduct.allow_oosp)}
                                                        {if $slideOptions.show_addtocart ==1 }
                                                                <a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_{$categoryProduct.id_product}" href="{$link->getPageLink('cart')|escape:'html'}?qty=1&amp;id_product={$categoryProduct.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='posproductcate'}">{l s='Add to cart' mod='posproductcate'}</a>
                                                        {/if}
                                                        {else}
                                                        {if $slideOptions.show_addtocart ==1 }
                                                                <span class="exclusive">{l s='Add to cart' mod='posproductcate'}</span>
                                                        {/if}
                                                        {/if}
                                        {else}
                                                        <div style="height:23px;"></div>
                                        {/if}

                                    </li>
                            {/foreach}
                    </ul>
            </div>
	</div>
	
</div>
{/if}

<script type="text/javascript">
	  $('#posproductcategory_list .bxslider').bxSlider({
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