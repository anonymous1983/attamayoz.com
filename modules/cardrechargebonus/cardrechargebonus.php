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

if (!defined('_PS_VERSION_'))
    exit;
include_once _PS_OVERRIDE_DIR_ . 'order/OrderState.php';
include_once _PS_MODULE_DIR_ . 'attamayozmodule/treeTypeClass.php';
include_once _PS_MODULE_DIR_ . 'attamayozcardmodule/cardRechargeClass.php';

//include_once _PS_MODULE_DIR_ . 'attamayozcardmodule/cardRechargeClass.php';


class Cardrechargebonus extends PaymentModule {

    private $_html = '';
    private $_postErrors = array();
    private $_ps_os_card_recharge_bonus = 1;
    public $cardrechargebonusName;
    public $address;
    public $extra_mail_vars;
    private $enable_payment = true;

    public function __construct() {
        $this->name = 'cardrechargebonus';
        $this->tab = 'payments_gateways';
        $this->version = '2.3';
        $this->author = 'PrestaShop';
        $this->dependencies = array('attamayozcardmodule', 'attamayozmodule');

        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        $config = Configuration::getMultiple(array('CARTE_BONUS_CHOICE'));
        if (isset($config['CARTE_BONUS_CHOICE']))
            $this->cardrechargebonusName = $config['CARTE_BONUS_CHOICE'];

        parent::__construct();

        $this->displayName = $this->l('Payments by card of recharge or bonus');
        $this->description = $this->l('This module allows you to accept payments by card of recharge or bonus.');
        $this->confirmUninstall = $this->l('Are you sure you want to delete these details?');


        $order_status = new OrderState();
        $order_status->invoice = 1;
        $order_status->send_email = 1;
        $order_status->module_name = $this->name;
        $order_status->color = 'LimeGreen';
        $order_status->paid = 1;
        $order_status->name = $this->l('Card Recharge or Bonus');
        $order_status->template = 'payment';



        // add order state cardrechargebonus
        $sql = 'SELECT COUNT(  `module_name` ) FROM `' . _DB_PREFIX_ . 'order_state` WHERE `module_name` = \'' . $this->name . '\'';
        if (!Db::getInstance()->getValue($sql)) {
            if ($order_status->add($this->context->language->id))
                $this->_ps_os_card_recharge_bonus = $result;
        }else {
            $this->_ps_os_card_recharge_bonus = $order_status->getIdOrderState($this->name);
        }

        /* if ((!isset($this->chequeName) || !isset($this->address) || empty($this->chequeName) || empty($this->address)))
          $this->warning = $this->l('"To the order of" and "address" must be configured before using this module.');
          if (!count(Currency::checkPaymentCurrencies($this->id)))
          $this->warning = $this->l('No currency has been set for this module');

          $this->extra_mail_vars = array(
          '{carte_bonnusCARTE_BONUS_CHOICE}' => Configuration::get('CARTE_BONUS_CHOICE'),
          '{cheque_address}' => Configuration::get('CHEQUE_ADDRESS'),
          '{cheque_address_html}' => str_replace("\n", '<br />', Configuration::get('CHEQUE_ADDRESS'))
          );
         * 
         */
    }

    public function install() {


        if (!parent::install() ||
                !$this->registerHook('displayHeader') ||
                !$this->registerHook('payment') ||
                !$this->registerHook('paymentReturn') ||
                !$this->registerHook('displayOrderConfirmation') ||
                !$this->registerHook('displayAdminCustomers') ||
                !Configuration::updateValue('PS_OS_CARD_RECHARGE_BONUS', $this->_ps_os_card_recharge_bonus))
            return false;

        // Crreat Table Tree
        $sql = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'tree (
                        `id_tree` int(11) NOT NULL AUTO_INCREMENT,
                        `id_tree_parent` int(11) NOT NULL DEFAULT 0,
                        `id_parent` int(11) NOT NULL DEFAULT 0,
                        `id_customer` int(11) NOT NULL,
                        `id_product` int(11) NOT NULL,
                        `id_order` int(11) NOT NULL,
                        `id_order_detail` int(11) NOT NULL,
                        `id_tree_type` int(11) NOT NULL,
                        `position` int(11) NOT NULL,
                        `cost` float NOT NULL,
                        `tree_children` TEXT,
                        `children` int(11) NOT NULL,
                        `current_children` int(11) NOT NULL,  
                        `active` tinyint(4) NOT NULL DEFAULT 1,
                        `deleted` tinyint(4) NOT NULL DEFAULT 0,
                        `archive` tinyint(4) NOT NULL DEFAULT 0,
                        `date_add` datetime NOT NULL,
                        `date_upd` datetime NOT NULL,
                        PRIMARY KEY (`id_tree`))
                        ENGINE=' . _MYSQL_ENGINE_ . ' default CHARSET=utf8';

        if (!Db::getInstance()->execute($sql))
            return false;

//                $now = time();
//                $object = new stdClass();
//                $object->id_customer = 0;
//                $object->id_order = 0;
//                $object->id_order_detail = 0;
//                $object->id_product = 0;
//                $object->date = date('Y-m-d H:i:s', $now);
//                
//                $c = json_encode(array($object,$object,$object,$object));
//                die($c);
//                $d = array('tree_type' => $c);
//                Db::getInstance()->insert('tree',$d);
//                
//                echo '<pre>';
//                print_r(json_decode($c));
//                die('x');

        return true;
    }

    public function uninstall() {
        if (!Configuration::deleteByName('CARTE_BONUS_CHOICE') || !parent::uninstall())
            return false;
        return true;
    }

    public function hookDisplayHeader($params) {
        $this->context->controller->addCSS($this->_path . 'views/css/cardrechargebonus.css', 'all');
    }

    public function hookPayment($params) {

        //die('hookPayment');

        if (!$this->active)
            return;
        if (!$this->cardrechargebonusCurrency($params['cart']))
            return;

        $cardRechargeClass = new cardRechargeClass();
        $total_balance = $cardRechargeClass->getTotalBalance($params['cart']->id_customer);
        $order_total = $this->context->cart->getOrderTotal();
        $this->smarty->assign(array(
            'this_path' => $this->_path,
            'this_path_crb' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
            'total_balance' => $cardRechargeClass->getTotalBalance($params['cart']->id_customer),
            'order_total' => $this->context->cart->getOrderTotal(),
            'can_use_crb' => ($total_balance > $order_total )
        ));
        return $this->display(__FILE__, 'payment.tpl');
    }

    public function hookPaymentReturn($params) {
        //die('hookPaymentReturn');
        if (!$this->active)
            return;

        $state = $params['objOrder']->getCurrentState();
        if ($state == Configuration::get('PS_OS_CARD_RECHARGE_BONUS') || $state == Configuration::get('PS_OS_OUTOFSTOCK')) {
            $this->smarty->assign(array(
                'total_to_pay' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
                'status' => 'ok',
                'id_order' => $params['objOrder']->id
            ));
            if (isset($params['objOrder']->reference) && !empty($params['objOrder']->reference))
                $this->smarty->assign('reference', $params['objOrder']->reference);
        }
        else
            $this->smarty->assign('status', 'failed');

        return $this->display(__FILE__, 'payment_return.tpl');
    }

    public function cardrechargebonusCurrency($cart) {
        $currency_order = new Currency((int) ($cart->id_currency));
        $currencies_module = $this->getCurrency((int) $cart->id_currency);

        if (is_array($currencies_module))
            foreach ($currencies_module as $currency_module)
                if ($currency_order->id == $currency_module['id_currency'])
                    return true;
        return false;
    }

    public function hookDisplayOrderConfirmation($params) {

//        echo '<pre>';
//        print_r($params['objOrder']);
//        echo 'Order id : ' . $params['objOrder']->id;
//        echo '----cartProducts----';
//        print_r($params['cartProducts']);
//        echo '<br>' . '----total_to_pay----';
//        print_r($params['total_to_pay']);
//        echo '<br>' . '----currency----';
//        print_r($params['currency']);
//        echo '<br>' . '----objOrder----' . '<br>';
//        print_r($params['objOrder']);
//        echo '<br>' . '----currencyObj----' . '<br>';
//        print_r($params['currencyObj']);

        if ($this->enable_payment)
            $this->payer($params['objOrder']->id_customer, $params['objOrder']->total_paid_real);
//      Bonus
        $this->setHistoryAndCalculBonus($params);
    }

    public function hookDisplayAdminCustomers($params) {
        $id_customer = $params['id_customer'];

        $sql = '
                SELECT * 
                FROM  `' . _DB_PREFIX_ . 'tree`
                WHERE id_tree_parent = ' . $id_customer . '
                OR id_customer = ' . $id_customer;

        $result = Db::getInstance()->executeS($sql);


        $discounts = Db::getInstance()->numRows();
        $this->smarty->assign(array(
            'history_bonus' => $result,
            'discounts' => $discounts,
            'suffix' => $this->context->currency->suffix,
            'total_bonus' => $this->getTotalBonusFromCustomer($id_customer)
        ));
        return $this->display(__FILE__, 'history_bonus.tpl');
    }

    public function setHistoryAndCalculBonus($params) {


        $cumul_bonnus = 0;
        $id_customer = $params['objOrder']->id_customer;
        foreach ($params['cartProducts'] as $product) {
            //echo '<pre>';
            $treeTypeClass = new treeTypeClass($product['id_tree_type']);
            $product_quantity = $product['product_quantity'];
            //echo '===== Nouveau Product ======'.'<br> >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> <br>';
            while ($product_quantity > 0) {
                //echo '===== product_quantity ======'.'<br>==============================<br>';
                //echo $product['product_quantity'];
                //echo '===== product_id ======'.'<br>==============================<br>';
                //echo $product['product_id'];
                //echo '===== id_tree_type======'.'<br>==============================<br>';
                $treeParent = $this->getParentTreeWhereCanAddBranch($id_customer, $treeTypeClass->id_tree_type);
                //echo '===== End Le meme Product '.$product_quantity.' ======'.' >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> <br>';

                if (count($treeParent) != 0)
                // add new parent tree
                    $this->newChildrenTree($params, $product, $treeTypeClass, $treeParent);
                else
                // add new parent tree
                    $this->newParentTree($params, $product, $treeTypeClass);

                $cumul_bonnus = floatval($cumul_bonnus) + floatval($treeTypeClass->cost);
                $product_quantity--;
            }
        }
        //$this->updateCustomerTotalBalanceWithBonus($cumul_bonnus, $id_customer);
        //die('hookDisplayOrderConfirmation');
        return TRUE;
    }

    function getTotalBonusFromCustomer($id_customer) {
        $sql = '
                SELECT SUM( cost ) AS sumcost
                FROM  `' . _DB_PREFIX_ . 'tree`
                WHERE id_tree_parent = ' . $id_customer . '
                OR id_customer = ' . $id_customer;
        return Db::getInstance()->getValue($sql);
    }

    /**
     * newTree
     *
     * Add new tree
     * @return bool
     */
    function newTree($params, $product, $treeTypeClass, $idTreeParent, $idParent, $now) {
        $now = time();
        // Add Tree Children
        //$treeTypeClass = new treeTypeClass($product['id_tree_type']);
        $data = array(
            'id_tree_parent' => $idTreeParent,
            'id_parent' => $idParent,
            'id_customer' => $params['objOrder']->id_customer,
            'id_product' => $product['product_id'],
            'id_order' => $product['id_order'],
            'id_order_detail' => $product['id_order_detail'],
            'id_tree_type' => $product['id_tree_type'],
            'cost' => $treeTypeClass->cost,
            'tree_children' => '0',
            'children' => $treeTypeClass->children,
            'date_add' => date('Y-m-d H:i:s', $now),
        );
        Db::getInstance()->insert('tree', $data);
        return (int)Db::getInstance()->Insert_ID();
    }

    /**
     * newParentTree 
     *
     * Add new parent tree
     * @return bool
     */
    function newParentTree($params, $product, $treeTypeClass) {
        $now = time();
        $this->newTree($params, $product, $treeTypeClass, '0', '0', $now);

        // Update Bonnus Cusomer
        $sql = 'UPDATE `' . _DB_PREFIX_ . 'customer` AS C  SET  C.bonnus= (C.bonnus + ' . $treeTypeClass->cost . ') , C.total_balance= (C.total_balance + ' . $treeTypeClass->cost . ') , C.date_upd = \'' . date('Y-m-d H:i:s', $now) . '\'  
                    WHERE 
                    C.id_customer = ' . $params['objOrder']->id_customer;
        Db::getInstance()->query($sql);

        return TRUE;
    }

    /**
     * newChildrenTree 
     *
     * Add new children tree
     * @return bool
     */
    function newChildrenTree($params, $product, $treeTypeClass, $treeParent) {
        $now = time();
        $idParentWhereCanAddBranch = $this->getIdParentWhereCanAddBranch($treeParent[0]['id_tree'], $treeTypeClass->x_axis);
        //echo '<pre>';
        //echo count($idParentWhereCanAddBranch);
        //echo '<br>';
        //print_r($idParentWhereCanAddBranch);
        //echo '<br>';
        //die($treeParent[0]['id_tree']."   ----  ".$treeTypeClass->x_axis);
        // Add Tree Children
        $idParentWhereCanAddBranch_id_tree = '0';
        if(count($idParentWhereCanAddBranch) != 0)
            $idParentWhereCanAddBranch_id_tree = $idParentWhereCanAddBranch[0]['id_tree'];
        
        $id_child_tree = $this->newTree($params, $product, $treeTypeClass, $treeParent[0]['id_tree'] , $idParentWhereCanAddBranch_id_tree, $now);
        
        /*$res_tree_parent = Db::getInstance()->getRow('SELECT * FROM  `' . _DB_PREFIX_ . 'tree` WHERE id_tree = ' . $treeParent[0]['id_tree']);
        $res_treeTypeClass = new treeTypeClass($res_tree_parent['id_tree_type']);
        if($res_tree_parent['tree_children'] < $res_treeTypeClass['x_axis']){

        }*/
        
        
        // Update Tree Children
        $sql = 'UPDATE `' . _DB_PREFIX_ . 'tree` AS T  SET  T.current_children= (T.current_children + 1) , T.date_upd = \'' . date('Y-m-d H:i:s', $now) . '\'  WHERE T.id_tree = ' . $treeParent[0]['id_tree'];
        Db::getInstance()->query($sql);


        // Update Bonnus Cusomer
        /*$sql2 = 'UPDATE `' . _DB_PREFIX_ . 'customer` AS C  SET  C.bonnus= (C.bonnus + ' . $treeTypeClass->cost . ') , C.total_balance= (C.total_balance + ' . $treeTypeClass->cost . ') , C.date_upd = \'' . date('Y-m-d H:i:s', $now) . '\'  
                    WHERE 
                    C.id_customer IN (
                        SELECT  `id_customer` 
                        FROM  `' . _DB_PREFIX_ . 'tree` 
                        WHERE  `id_tree` = ' . $treeParent[0]['id_tree'] . '
                        OR  `id_tree_parent` = ' . $treeParent[0]['id_tree'] . '
                    )';*/
        
        $recursive = '
                        SELECT `id_customer`, @pv:=id_parent as `id_parent` FROM `' . _DB_PREFIX_ . 'tree` AS T
                        join
                            (select @pv:=' . $id_child_tree . ')tmp
                        WHERE T.id_tree=@pv
                        ORDER BY T.id_tree DESC
                    ';
        $recursive_status = Db::getInstance()->executeS($recursive);
        foreach($recursive_status as $status_a) {
            $status_sql[] = '\''.$status_a['id_customer'].'\'';
        }
        $recursive = '
                        SELECT `id_customer` FROM `' . _DB_PREFIX_ . 'tree` TT 
                        WHERE 
                            TT.id_tree = ' . $treeParent[0]['id_tree'] . '
                            AND TT.id_tree_parent = 0
                            AND TT.id_parent = 0
                        LIMIT 1
                    ';
        $status = Db::getInstance()->executeS($recursive);
        $status_sql[] = $status[0]['id_customer'];
        $array_customer = implode(',',$status_sql);
        
        $sql2 = 'UPDATE `' . _DB_PREFIX_ . 'customer` AS C  SET  C.bonnus= (C.bonnus + ' . $treeTypeClass->cost . ') , C.total_balance= (C.total_balance + ' . $treeTypeClass->cost . ') , C.date_upd = \'' . date('Y-m-d H:i:s', $now) . '\'  
                    WHERE 
                    C.id_customer IN ( ' . $array_customer . ')
                ';
        
        Db::getInstance()->query($sql2);

        return TRUE;
    }

    /**
     * getTreeCustomerParent 
     *
     * search tree of parent id_customer an id_tree_type
     * @return Array
     */
    function getTreeCustomerParent($id_customer, $id_tree_type) {
        $object = new stdClass();
        $object->result_tab = Db::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'tree` WHERE `id_customer` = ' . $id_customer . ' AND `id_tree_type` = ' . $id_tree_type . ' AND `id_tree_parent` = 0');
        $object->result_obj = Db::getInstance()->execute('SELECT * FROM `' . _DB_PREFIX_ . 'tree` WHERE `id_customer` = ' . $id_customer . ' AND `id_tree_type` = ' . $id_tree_type . ' AND `id_tree_parent` = 0');
        return $object;
    }

    /**
     * getAllParentTreeFromIdTreeType 
     *
     * search all tree prent form id_tree_type
     * @return Array
     */
    function getAllParentTreeFromIdTreeType($id_tree_type) {
        $object = new stdClass();
        $object->result_tab = Db::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'tree` WHERE `id_tree_type` = ' . $id_tree_type . ' AND `id_tree_parent` = 0');
        $object->result_obj = Db::getInstance()->execute('SELECT * FROM `' . _DB_PREFIX_ . 'tree` WHERE `id_tree_type` = ' . $id_tree_type . ' AND `id_tree_parent` = 0');
        return $object;
    }

    /**
     * getParentTreeWhereCanAddBranch 
     *
     * recherche first tree where i can add branche
     * @return Array
     */
    function getParentTreeWhereCanAddBranch($id_customer, $id_tree_type) {
        $sql = '
                SELECT * 
                FROM  `' . _DB_PREFIX_ . 'tree` AS T
                WHERE T.id_tree_parent =0
                AND T.id_tree_type = ' . $id_tree_type . '
                AND T.`id_customer` != ' . $id_customer . '
                AND (
                    SELECT COUNT( * ) AS CONT
                    FROM  `' . _DB_PREFIX_ . 'tree` AS TC
                    WHERE TC.id_tree_parent = T.id_tree
                ) < T.children
                AND (
                    SELECT COUNT( * ) AS CONT
                    FROM  `' . _DB_PREFIX_ . 'tree` AS TC
                    WHERE TC.id_tree_parent = T.id_tree
                    AND TC.id_customer = ' . $id_customer . '
                ) = 0
                LIMIT 1
                ';
        return Db::getInstance()->executeS($sql);
    }


    /**
     * getIdParentWhereCanAddBranch 
     *
     * recherche first tree where i can add sub branche
     * @return Array
     */
    function getIdParentWhereCanAddBranch($id_tree_parent, $x_axis) {
        
        
        $sql = '
                SELECT COUNT( * ) AS CONT
                    FROM  `' . _DB_PREFIX_ . 'tree` AS T
                    WHERE 
                            T.id_tree_parent = ' . $id_tree_parent . '
                            AND T.id_parent = 0
                    LIMIT 1
                    ';
        
        $count = Db::getInstance()->executeS($sql);
        if(intval($count[0]['CONT']) >= $x_axis){
            $sql = '
                    SELECT * 
                    FROM  `' . _DB_PREFIX_ . 'tree` AS T
                    WHERE T.id_tree_parent = ' . $id_tree_parent . '
                    AND (
                        SELECT COUNT( * ) AS CONT
                        FROM att_db_tree AS TT
                        WHERE TT.id_parent = T.id_tree
                        AND TT.id_tree_parent = ' . $id_tree_parent . '
                    ) < ' . $x_axis . '
                    LIMIT 1';
            return Db::getInstance()->executeS($sql);
        }
        return null;
    }

    /**
     *  
     * UpdateCustomerTotalBalanceWithBonus 
     *
     * @return object
     */
    public function updateCustomerTotalBalanceWithBonus($bonus, $id_customer, $use = 1) {

        $customer = Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'customer` WHERE `id_customer` = ' . $id_customer);
        $total_balance = $customer['total_balance'];
        $_bonnus = $customer['bonnus'];
        $cost = $bonus;
        $data = array(
            'bonnus' => ((float) $_bonnus + (float) $bonus),
            'total_balance' => ((float) $total_balance + (float) $cost)
        );
        $where = 'id_customer = ' . $id_customer;
        if (!Db::getInstance()->update('customer', $data, $where))
            return FALSE;

        $object = new stdClass();
        $object->total_balance = ((float) $total_balance + (float) $cost);
        return $object;
    }

    /**
     * updateCustomerTotalBalanceWithBonus 
     *
     * @return object
     */
    public function payer($id_customer, $total_paid_real) {
        $customer = Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'customer` WHERE `id_customer` = ' . $id_customer);
        $total_balance = (float) $customer['total_balance'] - (float) $total_paid_real;
        $total_recharge = (float) $customer['total_recharge'] - (float) $total_paid_real;
        if ($total_recharge < 0)
            $total_recharge = 0;

        $data = array(
            'total_recharge' => $total_recharge,
            'total_balance' => $total_balance
        );
        $where = 'id_customer = ' . $id_customer;
        if (!Db::getInstance()->update('customer', $data, $where))
            return FALSE;

        $object = new stdClass();

        $object->total_balance = ((float) $total_balance + (float) $cost);
        return $object;
    }

}
