{*
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.comcarte de recharge
 *  International Registered Trademark & Property of karar-consulting SA
 *}

{if $status == 'ok'}
	<p>{l s='Your order on %s is complete.' sprintf=$shop_name mod='cardrechargebonus'}
		<br /><br />{l s='An email has been sent to you with this information.' mod='cardrechargebonus'}
		<br /><br /><strong>{l s='Your order will be sent.' mod='cardrechargebonus'}</strong>
		<br /><br />{l s='For any questions or for further information, please contact our' mod='cardrechargebonus'} <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='customer service department.' mod='cardrechargebonus'}</a>.
	</p>
{else}
	<p class="warning">
		{l s='We have noticed that there is a problem with your order. If you think this is an error, you can contact our' mod='cardrechargebonus'} 
		<a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='customer service department.' mod='cardrechargebonus'}</a>.
	</p>
{/if}
