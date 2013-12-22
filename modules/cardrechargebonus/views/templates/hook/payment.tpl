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

