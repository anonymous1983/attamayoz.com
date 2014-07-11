{*
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.comcarte de recharge
 *  International Registered Trademark & Property of karar-consulting SA
 *}

<p class="payment_module {if !$can_use_crb } cant_use {/if}">
        
        {if $can_use_crb }
            <img src="{$this_path_crb}/img/carte_de_recharge.jpg" alt="{l s='Pay by card Recharge or Bonus' mod='cardrechargebonus'}." width="86" height="49" />
            <a href="{$link->getModuleLink('cardrechargebonus', 'payment', [], true)|escape:'html'}" title="{l s='Pay by card Recharge or Bonus' mod='cardrechargebonus'}.">
                    {l s='Pay by card Recharge or Bonus' mod='cardrechargebonus'}
            </a>
            {if (Module::isInstalled('attamayozcardmodule')) }
                <a href="{$link->getModuleLink('attamayozcardmodule', 'account')|escape:'htmlall':'UTF-8'}" title="{l s='Recharge my account' mod='cardrechargebonus'}">
                    {l s='Recharge your account' mod='cardrechargebonus'}
                </a>
                <span class="total_balance"> <span class="text_">{l s='Your Total Card recharge and Bonus' mod='cardrechargebonus'} : </span><span class="total_ ">{$total_balance} {$currency->suffix}</span></span>
            {/if}
        {else}
            <img src="{$this_path_crb}/img/carte_de_recharge_disable.jpg" alt="{l s='Pay by card Recharge or Bonus' mod='cardrechargebonus'}." width="86" height="49" />
            <a class="error" href="{$link->getModuleLink('attamayozcardmodule', 'account')|escape:'htmlall':'UTF-8'}" title="{l s='Recharge my account' mod='cardrechargebonus'}">
                {l s='You can\'t use this mode of payment please recharge your account' mod='cardrechargebonus'}
            </a>
            <span class="total_balance"> <span class="text_">{l s='Your Total Card recharge and Bonus' mod='cardrechargebonus'} : </span><span class="total_ error ">{$total_balance} {$currency->suffix}</span></span>
        {/if}
        
</p>

