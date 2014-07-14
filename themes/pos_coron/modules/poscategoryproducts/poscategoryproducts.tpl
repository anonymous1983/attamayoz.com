<div class="pos-category-product block">
	<div class="pos-category-product-title title_block"><h4>{l s='Category Products' mod='poscategoryproducts'}</h4></div>
	{if count($trees_type)>1}
		<ul class="bxslider">
			{foreach from=$trees_type item=tree_type name=posCategoryProducts}
				<li class=" feature-productslider-item ajax_block_product">
                                    <a class="item-inner" href="{$link->getPageLink('treeproduct', true, NULL, "tree={$tree_type.id_tree_type}")|escape:'html'}">
                                      <span>{$tree_type.cost}</span> <sup>{$suffix}</sup>
					</a> <!--end item-inner-->
				</li>
			{/foreach}
		</ul>
	{else}
	<p class="warning">{l s='No products for this new products.' mod='poscategoryproducts'}</p>
	{/if}
	
	<script type="text/javascript">
		  $('.pos-category-product .bxslider').bxSlider({
            auto: {if $slideOptions.auto_slide != 1}{$slideOptions.auto_slide}{else}1{/if},
            slideWidth:{if $slideOptions.width_item != ''}{$slideOptions.width_item}{else}210{/if},
			slideMargin: 10,
			infiniteLoop: false,
			minSlides: {if $slideOptions.min_item != ''}{$slideOptions.min_item}{else}1{/if},
			maxSlides: {if $slideOptions.max_item != ''}{$slideOptions.max_item}{else}4{/if},
			speed:  {if $slideOptions.speed_slide != ''}{$slideOptions.speed_slide}{else}5000{/if},
			pause: {if $slideOptions.a_speed != ''}{$slideOptions.a_speed}{else}1000{/if},
			controls: {if $slideOptions.show_nexback != 0}{$slideOptions.show_nexback}{else}false{/if},
            pager: {if $slideOptions.show_control != 0}{$slideOptions.show_control}{else}false{/if},
		});
	</script>
		 
</div>
