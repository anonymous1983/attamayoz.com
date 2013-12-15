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
	var attamayozcardmodule_url_add = '{$link->getModuleLink('attamayozcardmodule', 'actions', ['process' => 'add'], false)|addslashes}';
	var attamayozcardmodule_url_remove = '{$link->getModuleLink('attamayozcardmodule', 'actions', ['process' => 'remove'], false)|addslashes}';
{if isset($smarty.get.id_product)}
	var attamayozcardmodule_id_product = '{$smarty.get.id_product|intval}';
{/if} 
</script>
