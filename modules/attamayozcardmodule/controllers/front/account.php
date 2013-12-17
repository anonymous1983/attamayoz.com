<?php
/*
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.comcarte de recharge
 *  International Registered Trademark & Property of karar-consulting SA
 */

/**
 * @since 1.5.0
 */
class AttamayozcardmoduleAccountModuleFrontController extends ModuleFrontController
{
	public $ssl = true;

	public function init()
	{
		parent::init();
		require_once($this->module->getLocalPath().'cardRechargeClass.php');
	}

	public function initContent()
	{
            
            parent::initContent();

		if (!Context::getContext()->customer->isLogged())
			Tools::redirect('index.php?controller=authentication&redirect=module&module=attamayozcardmodule&action=account');

		if (Context::getContext()->customer->id)
		{
                    $cardRechargeObject = new cardRechargeClass();
                    $sommecost = $cardRechargeObject->getSumCardsForCustomer((int)Context::getContext()->customer->id);
                    $sommecost = ($sommecost['sommecost'])? $sommecost['sommecost'] : 0;
                    $this->context->smarty->assign(array(
                        'id_customer' => Context::getContext()->customer->id,
                        'rechargecards' => $cardRechargeObject->getListCardsForCustomer((int)Context::getContext()->customer->id, (int)Context::getContext()->language->id),
                        'sum' => $sommecost,
                        'total_balance' => $cardRechargeObject->getTotalBalance(Context::getContext()->customer->id)
                        ));
                    $this->setTemplate('recharge_card-account.tpl');
		}
		
	}
}