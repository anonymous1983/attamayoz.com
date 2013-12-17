<?php
/*
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
*/

/**
 * @since 1.5.0
 */
class AttamayozcardmodulePaymentModuleFrontController extends ModuleFrontController
{
	public $ssl = true;

	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
            
		$this->display_column_left = false;
		parent::initContent();

		$cart = $this->context->cart;
                $currency = $this->context->currency;
                
                //echo '<pre>'; print_r($currency);
                
		if (!$this->module->checkCurrency($cart))
			Tools::redirect('index.php?controller=order');
                
                $smarty = array(
                            'nbProducts' => $cart->nbProducts(),
                            'cust_currency' => $cart->id_currency,
                            'currencies' => $currency->getCurrency((int)$cart->id_currency),
                            'total' => $cart->getOrderTotal(true, Cart::BOTH),
                            'isoCode' => $this->context->language->iso_code,
                            'products' => $cart->getProducts(),
                            'id_tree_type' => $this->module->getProductTreeType($cart->id_currency)
		);
                
		$this->context->smarty->assign($smarty);
                echo '<pre>'; print_r($smarty);
                
	}
}
