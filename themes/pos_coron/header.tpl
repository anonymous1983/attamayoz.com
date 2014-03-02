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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 " lang="{$lang_iso}"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="{$lang_iso}"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="{$lang_iso}"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="{$lang_iso}"> <![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
	<head>
		<title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
{if isset($meta_description) AND $meta_description}
		<meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />
{/if}
{if isset($meta_keywords) AND $meta_keywords}
		<meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
{/if}
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<meta http-equiv="content-language" content="{$meta_language}" />
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
		<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
		<link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
		<script type="text/javascript">
			var baseDir = '{$content_dir|addslashes}';
			var baseUri = '{$base_uri|addslashes}';
			var static_token = '{$static_token|addslashes}';
			var token = '{$token|addslashes}';
			var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
			var priceDisplayMethod = {$priceDisplay};
			var roundMode = {$roundMode};
		</script>
{if isset($css_files)}
	<link href="{$css_dir}bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="{$css_dir}bootstrap-responsive.css" rel="stylesheet" type="text/css" media="all" />
	{foreach from=$css_files key=css_uri item=media}
		{if !$css_uri|strstr:"global.css"} 
			<link href="{$css_uri}" rel="stylesheet" type="text/css"/>
		{/if}
	{/foreach}
	
{/if}

{if $POS_SKIN_DEFAULT &&  $POS_SKIN_DEFAULT !="default"}
 <link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$POS_THEMENAME}/css/global_{$POS_SKIN_DEFAULT}.css"/>
{else}
        <link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$POS_THEMENAME}/css/global_teal.css"/>
{/if}

{if isset($js_files)}
	{foreach from=$js_files item=js_uri}
	<script type="text/javascript" src="{$js_uri}"></script>
	{/foreach}
	<script src="{$js_dir}bootstrap/bootstrap-tooltip.js"  type="text/javascript" ></script>
	<script src="{$js_dir}bootstrap/bootstrap.min.js" type="text/javascript" ></script>
{/if}
		{$HOOK_HEADER}
	</head>
	
	<body {if isset($page_name)}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if} class="{if $hide_left_column}hide-left-column {/if} {if $hide_right_column}hide-right-column {/if} {if $content_only} content_only {/if}">
	{if $POS_PANELTOOL}
            {include file="{$POS_PANELTOOL_TPL}"}
        {/if} 
	{if !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
		<div id="restricted-country">
			<p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
		</div>
		{/if}
		<div id="page" class="pos_page">
			<div class="page-inner">
				<div class="container">
					<div class="container-inner">
			<!-- Header -->
			<div id="header">
					
							<div class="header-content">
								<a id="header_logo" href="{$base_dir}" title="{$shop_name|escape:'htmlall':'UTF-8'}">
									<img class="logo" src="{$logo_url}" alt="{$shop_name|escape:'htmlall':'UTF-8'}" {if $logo_image_width}width="{$logo_image_width}"{/if} {if $logo_image_height}height="{$logo_image_height}" {/if}/>
								</a>
								<div id="header_right">
									{$HOOK_TOP}
								</div>
							</div>
					
			</div>

			<div id="columns">
				
						{if $page_name =='category' || $page_name =='product' || $page_name =='products-comparison' || $page_name =='search'}
							{include file="$tpl_dir./breadcrumb.tpl"}
						{/if}
						<div class="main">
						<div class="row-fluid">	
							<!-- Left -->
							{if $page_name !='order' && $page_name !='module-bankwire-payment' && $page_name !='module-blockwishlist-mywishlist' && $page_name !='authentication'}
								<div id="left_column" class="span3">
									{$HOOK_LEFT_COLUMN}
								</div>
							{/if}
			
							<!-- Center -->
							<div id="center_column" class="{if $page_name !='order' && $page_name !='module-bankwire-payment' && $page_name !='module-blockwishlist-mywishlist' && $page_name !='authentication'}span9{else}span12{/if}">
								
				{/if}
