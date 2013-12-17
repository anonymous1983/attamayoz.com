{*
*
* 2013-2014 karar-consulting
*
*  @author karar-consulting SA <contact@karar-consulting.com>
*  @copyright  2013-2014 karar-consulting SA
*  @license    http://karar-consulting.com
*  International Registered Trademark & Property of karar-consulting SA
*
*}
<script type="text/javascript">
    $('document').ready(function()
    {
            $('.attamayozcardmodule_form_addRechargeCard .submit').click(function(event) {
                event.preventDefault();
                var $f = $('.attamayozcardmodule_form_addRechargeCard');
                var $code = $('.attamayozcardmodule_form_addRechargeCard #code').val();
                if($code)
                $.ajax({
                    url: "{$link->getModuleLink('attamayozcardmodule', 'actions', ['process' => 'add'], true)|addslashes}",
                    type: "POST",
                    data: $f.serialize(),
                    success: function(result)
                    {
                            if (parseInt(result) == 0) {
                                alert('Erreur code carte');
                            } else {
                                $('#attamayozcardmodule_block_account .rechargecards .warning').hide();
                                var obj = jQuery.parseJSON(result);
                                var sum = $('.totalprice').data('sum');
                                $('.totalprice').text(parseInt(sum) + parseInt(obj.cost));
                                $('.totalprice').data('sum', parseInt(sum) + parseInt(obj.cost));
                                var row = '<div class="rechargecard row clearfix" data-id_recharge_card="' + obj.id_recharge_card + '">' +
                                        '<div class="col col01 date">' + obj.date_use + '</div>' +
                                        '<div class="col col02 code">' + obj.code + '</div>' +
                                        '<div class="col col03 cost">' + obj.cost + '{$currency->suffix}</div>' +
                                        '</div>';
                                $('#attamayozcardmodule_block_account .rechargecards').prepend(row);
                            }
                            $('.attamayozcardmodule_form_addRechargeCard #code').val('');
                        }


                    });
                });
            });
</script>

{capture name=path}
    <a href="{$link->getPageLink('my-account', true)|escape:'htmlall':'UTF-8'}">
        {l s='My account' mod='attamayozcardmodule'}</a>
    <span class="navigation-pipe">{$navigationPipe}</span>{l s='My recharge cards' mod='attamayozcardmodule'}
{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
<div id="attamayozcardmodule_block_addRechargeCard">

    <form enctype="multipart/form-data" class="attamayozcardmodule_form_addRechargeCard form_custom" name="attamayozcardmodule_form_addRechargeCard"  id="attamayozcardmodule_form_addRechargeCard" method="post" action="/index.php?action=add">
        <fieldset>
            <h3 class="form_title">{l s='Add recharge card' mod='attamayozcardmodule'}</h3>
            <input type="hidden" name="id_customer" value="{$id_customer}">
            <input type="hidden" name="ajax" value="true">
            <p class="text">
                <label for="code">{l s='Card code' mod='attamayozcardmodule'}</label>
                <input type="text" class="text" id="code" name="code">
                <input type="submit" class="button_large btn submit" value="Envoyer" id="submitAddRechargeCard" name="submitMessage">
            </p>
        </fieldset>
    </form>
</div>

<div id="attamayozcardmodule_block_account" class="attamayozcardmodule_block_account">
    <h2 class="btitle btbgb0 table-title">{l s='My recharge cards' mod='attamayozcardmodule'} <div class="total"> <div class="text">Total :</div><div class="chifre"><span class="totalprice" data-sum="{$sum}">{$sum}</span> {$currency->suffix}</div></h2>
    <div class="rechargecard row clearfix  table-header btbgb1" data-id_recharge_card='{$rechargecard.id_recharge_card}'>
        <div class="col col01 date">{l s='date of use'  mod='attamayozcardmodule'}</div>
        <div class="col col02 code">{l s='code'  mod='attamayozcardmodule'}</div>
        <div class="col col03 cost">{l s='cost'  mod='attamayozcardmodule'}</div>
    </div>
    <div class="rechargecards">
        {if $rechargecards}
            {foreach from=$rechargecards item=rechargecard}
                <div class="rechargecard row clearfix" data-id_recharge_card='{$rechargecard.id_recharge_card}'>
                    <div class="col col01 date">{$rechargecard.date_use}</div>
                    <div class="col col02 code">{$rechargecard.code|escape:'htmlall':'UTF-8'}</div>
                    <div class="col col03 cost">{$rechargecard.cost} {$currency->suffix}</div>				
                </div>
            {/foreach}
        {else}
            <p class="warning">{l s='You do not have a recharge card for the moment.' mod='attamayozcardmodule'}</p>
        {/if}
    </div>

    <div  class="btitle btbgb1 ttl">
        <a href="{$link->getPageLink('my-account', true)|escape:'htmlall':'UTF-8'}">&LT; {l s='Back to your account.' mod='attamayozcardmodule'}</a>
        <div class="total"> <div class="text">Total :</div><div class="chifre"><span class="totalprice" data-sum="{$sum}">{$sum}</span> {$currency->suffix}</div> </div>
    </div>
</div>