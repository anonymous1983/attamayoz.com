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

<!-- Block permanent links module HEADER -->
<ul id="header_links">
	<li id="header_link_contact"><a class="link-contact" href="{$link->getPageLink('contact', true)|escape:'html'}" title="{l s='Contact' mod='blockpermanentlinks'}">{l s='Contact' mod='blockpermanentlinks'}</a></li>
	{$context = Context::getContext()}
<li><a class="link-wishlist wishlist_block" href="{$context->link->getModuleLink('blockwishlist', 'mywishlist')}" title="{l s='My wishlist' mod='blockpermanentlinks'}">{l s='My wishlist' mod='blockpermanentlinks'}</a></li>
	<li><a class="link-myaccount" href="{$link->getPageLink('my-account', true)|escape:'html'}" title="{l s='My account' mod='blockpermanentlinks'}">{l s='My account' mod='blockpermanentlinks'}</a></li>
	<li><a class="link-mycart" href="{$link->getPageLink('order', true)|escape:'html'}" title="{l s='My cart' mod='blockpermanentlinks'}">{l s='My cart' mod='blockpermanentlinks'}</a></li>
	{if $logged}
			<!--<a href="{$link->getPageLink('my-account', true)|escape:'html'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow"><span>{$cookie->customer_firstname} {$cookie->customer_lastname}</span></a>-->
			<li class="last"><a class="link-out" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html'}" title="{l s='Log out' mod='blockpermanentlinks'}" class="logout" rel="nofollow">{l s='Log out' mod='blockpermanentlinks'}</a></li>
		{else}
			<li class="last"><a class="link-login" href="{$link->getPageLink('my-account', true)|escape:'html'}" title="{l s='Login' mod='blockpermanentlinks'}" class="login" rel="nofollow">{l s='Login' mod='blockpermanentlinks'}</a></li>
	{/if}
	
</ul>
<!-- /Block permanent links module HEADER -->
