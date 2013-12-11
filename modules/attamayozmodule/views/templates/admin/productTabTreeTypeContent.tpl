{*
 *
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.com
 *  International Registered Trademark & Property of karar-consulting SA
 *}

    {*call the content, sent by producttab.php script to this template :*}
    {* <pre>{$context->controller->tpl_form_vars->id_product|@print_r} *}
    <input type="hidden" name="submitted_tabs[]" value="Tree" />
    <input type="hidden" name="tree_type_current_id" value="{$tree_type_current_id}" />
    <div id="stepAttamayoz">
        <h4 class="tab">13. {l s='Tree'}</h4>
        <h4>{l s='Product Tree'}</h4>
        <div class="separation"></div>
        {* status informations *}
        <table cellpadding="5" style="width: 100%; margin-left: 10px;">
            <tr>
                <td class="col-left">
                        <label>{l s='Tree type'} : </label>
                </td>
                <td style="padding-bottom:5px;" >
                    <select name="treetype" id="treetype" style="width: 250px;">
                        <option value="0">{l s='Type'}</option>
                            {foreach from=$tree_type_list item=tree_type key=key}
                                <option  value="{$tree_type.id_tree_type}" {if $tree_type.id_tree_type == $tree_type_current_id}selected="selected"{/if}  >{$tree_type.title}</option>
                            {/foreach}    
                    </select>
                </td>
            </tr>
        </table>
    </div>