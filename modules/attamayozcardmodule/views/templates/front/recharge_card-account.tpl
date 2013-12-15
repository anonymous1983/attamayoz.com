{*
*
* 2013-2014 karar-consulting
*
*  @author karar-consulting SA <contact@karar-consulting.com>
*  @copyright  2013-2014 karar-consulting SA
*  @license    http://karar-consulting.com
*  International Registered Trademark & Property of karar-consulting SA
*}
<script type="text/javascript">
$('document').ready(function()
{
$('.attamayozcardmodule_form_addRechargeCard .submit').click(function(event){
            event.preventDefault();
            var $f = $('.attamayozcardmodule_form_addRechargeCard');

            $.ajax({
                    url: "{$link->getModuleLink('attamayozcardmodule', 'actions', ['process' => 'add'], true)|addslashes}",
                    type: "POST",
                    data: $f.serialize(),
                    success: function(result)
                    {
                        if(parseInt(result)){
                            alert('true');
                        }else{
                            alert('false');
                        }
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

    <form enctype="multipart/form-data" class="attamayozcardmodule_form_addRechargeCard form_custom" method="post" action="/index.php?action=add">
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

<div id="attamayozcardmodule_block_account">
    <h2 class="btitle btbgb0">{l s='My recharge cards' mod='attamayozcardmodule'}</h2>
    {if $rechargecards}
        <div>
            {foreach from=$rechargecards item=rechargecard}
                <div class="rechargecard row clearfix">
                    <div class="col col01 date">{$rechargecard.date_use}</div>
                    <div class="col col02 code">{$rechargecard.code|escape:'htmlall':'UTF-8'}</div>
                    <div class="col col03 cost">{$rechargecard.cost}</div>				
                </div>
            {/foreach}
        </div>
    {else}
        <p class="warning">{l s='You do not have a recharge card for the moment.' mod='attamayozcardmodule'}</p>
    {/if}

    <div  class="btitle btbgb1 ttl">
        <a href="{$link->getPageLink('my-account', true)|escape:'htmlall':'UTF-8'}">&LT; {l s='Back to your account.' mod='attamayozcardmodule'}</a>
    </div>
</div>