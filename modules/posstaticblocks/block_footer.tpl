<div class="pos-staticblock-container">
	<div id="pos-staticblock-home" class="block">
            <div class="row-fluid">
		{foreach from=$staticblocks key=key item=block}
			{if $block.active == 1}
				<p class ="title_block"> {l s={$block.title} } </p>
                              
			{/if}
			{$block.description}
                        {if $block.insert_module == 1}
                         <div class ='block_module_{$block.module_name}'>
                              {$block.block_module}
                         </div>
                         {/if}
		{/foreach}
            </div>
	</div>
</div>
