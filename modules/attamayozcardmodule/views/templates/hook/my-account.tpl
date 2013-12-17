{*
 *
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.com
 *  International Registered Trademark & Property of karar-consulting SA
 *}

 <li class='rechargecard'>
     <a href="{$link->getModuleLink('attamayozcardmodule', 'account')|escape:'htmlall':'UTF-8'}" title="{l s='Recharge card' mod='attamayozcardmodule'}">
         {if !$in_footer}<img {if isset($mobile_hook)}src="{$module_template_dir}img/cards.png" class="ui-li-icon ui-li-thumb"{else}src="{$module_template_dir}img/cards.png" class="icon"{/if} alt="{l s='Recharge card' mod='attamayozcardmodule'}"/>{/if}
         {l s='My recharge card' mod='attamayozcardmodule'}
     </a>
 </li>
 <li class="total_balance"> <span class="text_">{l s='Votre Total de Carte de recharge ou Bonnus' mod='attamayozcardmodule'} = </span><span class="total_">{$total_balance} {$currency->suffix}</span></li>