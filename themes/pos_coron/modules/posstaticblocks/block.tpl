{if $page_name == 'index'}

	  {foreach from=$staticblocks key=key item=block}
	       <div class="home-banner-contain">
		    <div class="row-fluid">
		  {if $block.active == 1}
			  <p class ="title_block"> {l s={$block.title} } </p>
			
		  {/if}
		  {$block.description}
		  {if $block.insert_module == 1}
			{$block.block_module}
		   {/if}
		        </div>
		    </div>
	  {/foreach}

{/if}