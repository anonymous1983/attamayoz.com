<div class="pos-logo-container">
		<div class="container-inner">
			<div class="pos-logo block">
				<div class="pos-logo-title title_block"><h4>{l s='Brands' mod='poslogo'}</h4></div>
					
					<ul class="bxslider">
						{foreach from=$logos item=logo name=posLogo}
							<li>
							    <a href ="{$logo.link}">
									<img src ="{$logo.image}" alt ="{l s="Logo"}" />
							    </a>
							</li>
						{/foreach}
					</ul>
					
			</div>
		</div>
	</div>
	<script type="text/javascript">
		  $('.pos-logo .bxslider').bxSlider({
            auto: {if $slideOptions.auto != 1}{$slideOptions.auto}{else}1{/if},
            slideWidth:{if $slideOptions.width_item != ''}{$slideOptions.width_item}{else}127{/if},
			slideMargin: 20,
			
			minSlides: {if $slideOptions.min_item != ''}{$slideOptions.min_item}{else}1{/if},
			maxSlides: {if $slideOptions.max_item != ''}{$slideOptions.max_item}{else}12{/if},
			speed:  {if $slideOptions.speed_slide != ''}{$slideOptions.speed_slide}{else}3000{/if},
			pause: {if $slideOptions.a_speed != ''}{$slideOptions.a_speed}{else}3000{/if},
			controls: {if $slideOptions.show_nexback != 0}{$slideOptions.show_nexback}{else}false{/if},
            pager: {if $slideOptions.show_control != 0}{$slideOptions.show_control}{else}false{/if},
		});
	</script>
		 
</div>