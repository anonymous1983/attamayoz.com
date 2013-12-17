{*
*
* 2013-2014 karar-consulting
*
*  @author karar-consulting SA <contact@karar-consulting.com>
*  @copyright  2013-2014 karar-consulting SA
*  @license    http://karar-consulting.com
*  International Registered Trademark & Property of karar-consulting SA
*}
{capture name=path}{l s='Carte de recharge ou Bonnus payment.' mod='attamayozcardmodule'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='attamayozcardmodule'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.' mod='attamayozcardmodule'}</p>
{else}

<h3>{l s='Carte de recharge ou Bonnus payment.' mod='attamayozcardmodule'}</h3>
<form action="{$link->getModuleLink('attamayozcardmodule', 'validation', [], true)|escape:'html'}" method="post">
<p>
	<img src="{$module_template_dir}img/carte_de_recharge.jpg" alt="{l s='Carte de recharge ou Bonnus' mod='attamayozcardmodule'}" width="86" height="49" style="float:left; margin: 0px 10px 5px 0px;"/>
	{l s='You have chosen to pay by Carte de recharge ou Bonnus.' mod='attamayozcardmodule'}
	<br/><br />
	{l s='Here is a short summary of your order:' mod='attamayozcardmodule'}
</p>
<p style="margin-top:20px;">
	- {l s='The total amount of your order is' mod='attamayozcardmodule'}
	<span id="amount" class="price">{displayPrice price=$total}</span>
	{if $use_taxes == 1}
    	{l s='(tax incl.)' mod='attamayozcardmodule'}
    {/if}
</p>

<p>
	{l s='Carte de recharge ou Bonnus account information will be displayed on the next page.' mod='attamayozcardmodule'}
	<br /><br />
	<b>{l s='Please confirm your order by clicking "Place my order."' mod='attamayozcardmodule'}.</b>
</p>
<p class="cart_navigation" id="cart_navigation">
	<input type="submit" value="{l s='Place my order' mod='attamayozcardmodule'}" class="exclusive_large" />
	<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html'}" class="button_large">{l s='Other payment methods' mod='attamayozcardmodule'}</a>
</p>
</form>
{/if}
