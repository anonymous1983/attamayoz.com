{*
* 2013-2014 karar-consulting
*
*  @author karar-consulting SA <contact@karar-consulting.com>
*  @copyright  2013-2014 karar-consulting SA
*  @license    http://karar-consulting.comcarte de recharge
*  International Registered Trademark & Property of karar-consulting SA
*}
<script>
    $(document).ready(function(){
        var current_row = $('.table_history_bonnus .row_history:eq(0)').data('id_order');
        var cr = 0;
        $('.table_history_bonnus .row_history').each(function(i){
            if(i){
                if($(this).data('id_order') === current_row){
                    $(this).hide();
                    $(this).find('.developper').html('');
                }else{
                   current_row = $(this).data('id_order');
                }
            }
        });
        $('.table_history_bonnus .row_history:visible').each(function(){
            if($('.table_history_bonnus .row_history.row_'+$(this).data('id_order')).length > 1)
                $(this).addClass('parent');
        });
        $('.table_history_bonnus .row_history.parent').click(function(){
            $('.table_history_bonnus .row_history.parent.row_'+cr+' .developper').html('+');
            $('.table_history_bonnus .row_history.row_'+cr+'').not('.parent').hide();
            $('.table_history_bonnus .row_history.row_'+$(this).data('id_order')).show();
            $('.table_history_bonnus .row_history.parent.row_'+$(this).data('id_order')+' .developper').html('-');
            cr = $(this).data('id_order');
        });
        
    });
</script>
{l s='An email has been sent to you with this information.' mod='cardrechargebonus'}
<div style="width:100%;">
    <div>
        <h2>{l s='History of bonus' mod='cardrechargebonus'} ({$discounts})</h2>
        {if count($discounts)}
            <table cellspacing="0" cellpadding="0" class="table table_history_bonnus" style="width:100%; text-align:left;">
                    <colgroup>
                            <col width="10px">
                            <col width="100px">
                            <col width="100px">
                            <col width="200px">
                            <col width="100px">
                            <col width="">
                            <col width="100">
                    </colgroup>
                    <tr>
                            <th width="10px"></th>
                            <th height="39px">{l s='ID'}</th>
                            <th class="left">{l s='ID Parent'}</th>
                            <th class="left">{l s='Date'}</th>
                            <th class="left">{l s='Bonus'}</th>
                            <th class="left">{l s='Position'}</th>
                            <th class="center">{l s='Actions'}</th>
                    </tr>
                    {foreach $history_bonus AS $key => $row_bonus}
                            <tr class=" {if $key %2}alt_row{/if} row_history row_{$row_bonus['id_order']}" data-id_order="{$row_bonus['id_order']}" style="cursor: pointer">
                                    <td class="left developper">+</td>
                                    <td class="left">{$row_bonus['id_tree']}</td>
                                    <td class="left">{$row_bonus['id_tree_parent']}</td>
                                    <td class="left">{$row_bonus['date_add']}</td>
                                    <td class="left">{$row_bonus['cost']}{$suffix}</td>
                                    <td class="left">{$row_bonus['position']}</td>
                                    <td align="center"><a href="?tab=AdminOrders&id_order={$row_bonus['id_order']}&vieworder&token={getAdminToken tab='AdminOrders'}"><img src="../img/admin/details.gif" /></a></td>
                            </tr>
                    {/foreach}
                    
            </table>
                    <strong style="padding-top: 10px; display: block; clear: both; color: red; text-align: left; padding-left: 100px;">
                         {l s='Total des bonus = '}  {$total_bonus}{$suffix}
                    </strong>
        {else}
            {* {l s='%1$s %2$s has no discount vouchers' sprintf=[$customer->firstname, $customer->lastname]}. *}
        {/if}
    </div>
</div>
