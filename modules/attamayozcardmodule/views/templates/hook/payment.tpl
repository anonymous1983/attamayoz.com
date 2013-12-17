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
<script type="text/javascript">
    $('document').ready(function()
    {
            $('#HOOK_PAYMENT').append($('#payment_current_sold'));
        });
</script>
<p class="payment_module" id="payment_current_sold">
    <img src="{$module_template_dir}img/carte_de_recharge.jpg" alt="{l s='Carte de recharge ou Bonnus' mod='attamayozcardmodule'}" width="86" height="49"/>
    <a href="{$link->getModuleLink('attamayozcardmodule', 'payment')|escape:'html'}" title="{l s='Carte de recharge ou Bonnus' mod='attamayozcardmodule'}">
        {l s='Carte de recharge ou Bonnus' mod='attamayozcardmodule'}
    </a>
    <a href="{$link->getModuleLink('attamayozcardmodule', 'account')|escape:'htmlall':'UTF-8'}" title="{l s='Recharge card' mod='attamayozcardmodule'}">
        {l s='Recharger mon compte' mod='attamayozcardmodule'}
    </a>
        <span class="total_balance"> <span class="text_">{l s='Votre Total de Carte de recharge ou Bonnus' mod='attamayozcardmodule'} = </span><span class="total_">{$total_balance} {$currency->suffix}</span></span>
</p>