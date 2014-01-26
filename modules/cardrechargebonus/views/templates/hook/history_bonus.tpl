{*
* 2013-2014 karar-consulting
*
*  @author karar-consulting SA <contact@karar-consulting.com>
*  @copyright  2013-2014 karar-consulting SA
*  @license    http://karar-consulting.comcarte de recharge
*  International Registered Trademark & Property of karar-consulting SA
*}

{l s='An email has been sent to you with this information.' mod='cardrechargebonus'}
<div style="width:100%;">
    <div>
        <h2>{l s='History of bonus' mod='cardrechargebonus'} ({$discounts})</h2>
        {if count($discounts)}
            <table cellspacing="0" cellpadding="0" class="table" style="width:100%; text-align:left;">
                    <colgroup>
                            <col width="100px">
                            <col width="100px">
                            <col width="200px">
                            <col width="100px">
                            <col width="">
                            <col width="100">
                    </colgroup>
                    <tr>
                            <th height="39px">{l s='ID'}</th>
                            <th class="left">{l s='ID Parent'}</th>
                            <th class="left">{l s='Date'}</th>
                            <th class="left">{l s='Bonus'}</th>
                            <th class="left">{l s='Position'}</th>
                            <th class="center">{l s='Actions'}</th>
                    </tr>
                    
                    {foreach $history_bonus AS $key => $row_bonus}
                            <tr {if $key %2}class="alt_row"{/if} style="cursor: pointer" onclick="document.location = '?tab=AdminOrders&id_order={$row_bonus['id_order']}&vieworder&token={getAdminToken tab='AdminOrders'}'">
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
