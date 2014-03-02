<?php
if (!defined('_PS_VERSION_'))
	exit;

class posproductcates extends Module
{
 	private $_html;

	public function __construct()
 	{
 	 	$this->name = 'posproductcates';
 	 	$this->version = '1.0';
		$this->author = 'Posthemes';
 	 	$this->tab = 'front_office_features';
		$this->need_instance = 0;
		
		parent::__construct();
		
		$this->displayName = $this->l('Products Category with slider');
		$this->description = $this->l('Display products of the same category on the product page.');
		
		if (!$this->isRegisteredInHook('header'))
			$this->registerHook('header');
 	}

	public function install()
	{
                $this->_clearCache('productscategory.tpl');
                Configuration::updateValue('POSPRODUCTCATE', 8);
                Configuration::updateValue($this->name . '_auto_slide', 0);
                Configuration::updateValue($this->name . '_speed_slide', '3000');
                Configuration::updateValue($this->name . '_a_speed', '3000');
                Configuration::updateValue($this->name . '_show_price', 1);
                Configuration::updateValue($this->name . '_show_des', 0);
                Configuration::updateValue($this->name . '_qty_products', 20);
                Configuration::updateValue($this->name . '_qty_items', 4);
                Configuration::updateValue($this->name . '_width_item', 205);
                Configuration::updateValue($this->name . '_show_nextback', 1);
                Configuration::updateValue($this->name . '_show_control', 0);
                Configuration::updateValue($this->name . '_min_item', 2);
                Configuration::updateValue($this->name . '_max_item', 4);
                Configuration::updateValue($this->name . '_show_addtocart', 0);
		$this->_clearCache('productscategory.tpl');
	 	return (parent::install()
			&& $this->registerHook('productfooter')
			&& $this->registerHook('header')
			&& $this->registerHook('addproduct')
			&& $this->registerHook('updateproduct')
			&& $this->registerHook('deleteproduct')
		);
	}
	
	public function uninstall()
	{
                Configuration::deleteByName($this->name . '_auto_slide');
                Configuration::deleteByName($this->name . '_speed_slide');
                Configuration::deleteByName($this->name . '_a_speed');
                Configuration::deleteByName($this->name . '_show_price');
                Configuration::deleteByName($this->name . '_show_des');
                Configuration::deleteByName($this->name . '_qty_products');
                Configuration::deleteByName($this->name . '_qty_items');
                Configuration::deleteByName($this->name . '_width_item');
                Configuration::deleteByName($this->name . '_show_nextback');
                Configuration::deleteByName($this->name . '_show_control');
                Configuration::deleteByName($this->name . '_min_item');
                Configuration::deleteByName($this->name . '_max_item');
                Configuration::deleteByName($this->name . '_show_addtocart');
		//Configuration::deleteByName('PRODUCTSCATEGORY_DISPLAY_PRICE');
		$this->_clearCache('productscategory.tpl');
	 	return parent::uninstall();
	}
	
	private function _postProcess() {
        Configuration::updateValue($this->name . '_auto_slide', Tools::getValue('auto_slide'));
        Configuration::updateValue($this->name . '_speed_slide', Tools::getValue('speed_slide'));
        Configuration::updateValue($this->name . '_a_speed', Tools::getValue('a_speed'));
        Configuration::updateValue($this->name . '_show_price', Tools::getValue('show_price'));
        Configuration::updateValue($this->name . '_show_des', Tools::getValue('show_des'));
        Configuration::updateValue($this->name . '_qty_products', Tools::getValue('qty_products'));
        Configuration::updateValue($this->name . '_qty_items', Tools::getValue('qty_items'));
        Configuration::updateValue($this->name . '_width_item', Tools::getValue('width_item'));
        Configuration::updateValue($this->name . '_show_nextback', Tools::getValue('show_nextback'));
        Configuration::updateValue($this->name . '_show_control', Tools::getValue('show_control'));
        Configuration::updateValue($this->name . '_min_item', Tools::getValue('min_item'));
        Configuration::updateValue($this->name . '_max_item', Tools::getValue('max_item'));
        Configuration::updateValue($this->name . '_show_addtocart', Tools::getValue('show_addtocart'));



        $this->_html .= '<div class="conf confirm">' . $this->l('Settings updated') . '</div>';
    }
    
     public function getContent() {
        $output = '<h2>' . $this->displayName . '</h2>';
        if (Tools::isSubmit('submitPostProductCate')) {
            if (!sizeof($this->_postErrors))
                $this->_postProcess();
            else {
                foreach ($this->_postErrors AS $err) {
                    $this->_html .= '<div class="alert error">' . $err . '</div>';
                }
            }
        }
        return $output . $this->_displayForm();
    }

    public function getSelectOptionsHtml($options = NULL, $name = NULL, $selected = NULL) {
        $html = "";
        $html .='<select name =' . $name . ' style="width:130px">';
        if (count($options) > 0) {
            foreach ($options as $key => $val) {
                if (trim($key) == trim($selected)) {
                    $html .='<option value=' . $key . ' selected="selected">' . $val . '</option>';
                } else {
                    $html .='<option value=' . $key . '>' . $val . '</option>';
                }
            }
        }
        $html .= '</select>';
        return $html;
    }

    private function _displayForm() {
        $this->_html .= '
		<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                  <fieldset>
                    <legend><img src="../img/admin/cog.gif" alt="" class="middle" />' . $this->l('Settings') . '</legend>
                     <label>' . $this->l('Auto slide: ') . '</label>
                    <div class="margin-form">';
        $this->_html .= $this->getSelectOptionsHtml(array(0 => 'No', 1 => 'Yes'), 'auto_slide', (Tools::getValue('auto_slide') ? Tools::getValue('auto_slide') : Configuration::get($this->name . '_auto_slide')));
        $this->_html .='
                    </div>
                     <label>' . $this->l('Min Items: ') . '</label>
                    <div class="margin-form">
                            <input type = "text"  name="min_item" value =' . (Tools::getValue('min_item') ? Tools::getValue('min_item') : Configuration::get($this->name . '_min_item')) . ' ></input>
                    </div>
                    <label>' . $this->l('Max Items: ') . '</label>
                    <div class="margin-form">
                            <input type = "text"  name="max_item" value =' . (Tools::getValue('max_item') ? Tools::getValue('max_item') : Configuration::get($this->name . '_max_item')) . ' ></input>
                    </div>
                 
                     <label>' . $this->l('Slideshow speed: ') . '</label>
                    <div class="margin-form">
                            <input type = "text"  name="speed_slide" value =' . (Tools::getValue('speed_slide') ? Tools::getValue('speed_slide') : Configuration::get($this->name . '_speed_slide')) . ' ></input>
                    </div>
                      <label>' . $this->l('Pause: ') . '</label>
                    <div class="margin-form">
                            <input type = "text"  name="a_speed" value =' . (Tools::getValue('a_speed_slide') ? Tools::getValue('a_speed') : Configuration::get($this->name . '_a_speed')) . ' ></input>
                    </div>
                      <label>' . $this->l('Show Price: ') . '</label>
                    <div class="margin-form">';
        $this->_html .= $this->getSelectOptionsHtml(array(0 => 'No', 1 => 'Yes'), 'show_price', (Tools::getValue('title') ? Tools::getValue('show_price') : Configuration::get($this->name . '_show_price')));
        $this->_html .='
                    </div>
                      <label>' . $this->l('Show Description: ') . '</label>
                    <div class="margin-form">';
        $this->_html .= $this->getSelectOptionsHtml(array(0 => 'No', 1 => 'Yes'), 'show_des', (Tools::getValue('title') ? Tools::getValue('show_des') : Configuration::get($this->name . '_show_des')));
        $this->_html .='
                    </div>
                      <label>' . $this->l('Show Add To Cart') . '</label>
                    <div class="margin-form">';
        $this->_html .= $this->getSelectOptionsHtml(array(0 => 'No', 1 => 'Yes'), 'show_addtocart', (Tools::getValue('title') ? Tools::getValue('show_addtocart') : Configuration::get($this->name . '_show_addtocart')));
        $this->_html .='
                    </div>
                     <label>' . $this->l('Qty of Products: ') . '</label>
                    <div class="margin-form">
                            <input type = "text"  name="qty_products" value =' . (Tools::getValue('qty_products') ? Tools::getValue('qty_products') : Configuration::get($this->name . '_qty_products')) . ' ></input>
                    </div>
                      <label>' . $this->l('Width of Item:  ') . '</label>
                    <div class="margin-form">
                            <input type = "text"  name="width_item" value =' . (Tools::getValue('width_item') ? Tools::getValue('width_item') : Configuration::get($this->name . '_width_item')) . ' ></input>
                    </div>
                    <label>' . $this->l('Show Next/Back control: : ') . '</label>
                    <div class="margin-form">';
        $this->_html .= $this->getSelectOptionsHtml(array(0 => 'No', 1 => 'Yes'), 'show_nextback', (Tools::getValue('title') ? Tools::getValue('show_nextback') : Configuration::get($this->name . '_show_nextback')));
        $this->_html .='
                    </div>
                    <label>' . $this->l('Show navigation control: : ') . '</label>
                     <div class="margin-form">';
        $this->_html .= $this->getSelectOptionsHtml(array(0 => 'No', 1 => 'Yes'), 'show_control', (Tools::getValue('title') ? Tools::getValue('show_control') : Configuration::get($this->name . '_show_control')));
        $this->_html .='
                    </div>
                    <input type="submit" name="submitPostProductCate" value="' . $this->l('Update') . '" class="button" />
                     </fieldset>
		</form>';
        return $this->_html;
    }
	
	private function getCurrentProduct($products, $id_current)
	{
		if ($products)
			foreach ($products AS $key => $product)
				if ($product['id_product'] == $id_current)
					return $key;
		return false;
	}
	
	public function hookProductFooter($params)
	{   
		$id_product = (int)$params['product']->id;
            	$product = $params['product'];
		
		$cache_id = 'productscategory|'.$id_product.'|'.(isset($params['category']->id_category) ? (int)$params['category']->id_category : $product->id_category_default);

		if (!$this->isCached('productscategory.tpl', $this->getCacheId($cache_id)))
		{
			/* If the visitor has came to this product by a category, use this one */
			if (isset($params['category']->id_category))
				$category = $params['category'];
			/* Else, use the default product category */
			else
			{
				if (isset($product->id_category_default) AND $product->id_category_default > 1)
					$category = new Category((int)$product->id_category_default);
			}
			
			if (!Validate::isLoadedObject($category) OR !$category->active) 
				return;

			// Get infos
			$categoryProducts = $category->getProducts($this->context->language->id, 1, 100); /* 100 products max. */
			$sizeOfCategoryProducts = (int)sizeof($categoryProducts);
			$middlePosition = 0;
			
			// Remove current product from the list
			if (is_array($categoryProducts) AND sizeof($categoryProducts))
			{
				foreach ($categoryProducts AS $key => $categoryProduct)
					if ($categoryProduct['id_product'] == $id_product)
					{
						unset($categoryProducts[$key]);
						break;
					}

				$taxes = Product::getTaxCalculationMethod();
					foreach ($categoryProducts AS $key => $categoryProduct)
						if ($categoryProduct['id_product'] != $id_product)
						{
							if ($taxes == 0 OR $taxes == 2)
								$categoryProducts[$key]['displayed_price'] = Product::getPriceStatic((int)$categoryProduct['id_product'], true, NULL, 2);
							elseif ($taxes == 1)
								$categoryProducts[$key]['displayed_price'] = Product::getPriceStatic((int)$categoryProduct['id_product'], false, NULL, 2);
						}
			
				// Get positions
				$middlePosition = round($sizeOfCategoryProducts / 2, 0);
				$productPosition = $this->getCurrentProduct($categoryProducts, (int)$id_product);
			
				// Flip middle product with current product
				if ($productPosition)
				{
					$tmp = $categoryProducts[$middlePosition-1];
					$categoryProducts[$middlePosition-1] = $categoryProducts[$productPosition];
					$categoryProducts[$productPosition] = $tmp;
				}
			
				// If products tab higher than 30, slice it
				if ($sizeOfCategoryProducts > 30)
				{
					$categoryProducts = array_slice($categoryProducts, $middlePosition - 15, 30, true);
					$middlePosition = 15;
				}
			}
                           $slideOptions = array(
                                'auto_slide' => Configuration::get($this->name . '_auto_slide'),
                                'speed_slide' => Configuration::get($this->name . '_speed_slide'),
                                'a_speed' => Configuration::get($this->name . '_a_speed'),
                                'show_price' => Configuration::get($this->name . '_show_price'),
                                'show_des' => Configuration::get($this->name . '_show_des'),
                                'qty_products' => Configuration::get($this->name . '_qty_products'),
                                'qty_items' => Configuration::get($this->name . '_qty_items'),
                                'width_item' => Configuration::get($this->name . '_width_item'),
                                'show_nexback' => Configuration::get($this->name . '_show_nextback'),
                                'show_control' => Configuration::get($this->name . '_show_control'),
                                'min_item' => Configuration::get($this->name . '_min_item'),
                                'max_item' => Configuration::get($this->name . '_max_item'),
                                'show_addtocart' => Configuration::get($this->name . '_show_addtocart'),
                            );
			
			// Display tpl
			$this->smarty->assign(array(
				'categoryProducts' => $categoryProducts,
				'middlePosition' => (int)$middlePosition,
                                'slideOptions' => $slideOptions
			));
		}
		return $this->display(__FILE__, 'productscategory.tpl', $this->getCacheId($cache_id));
	}
	
	public function hookHeader($params)
	{
		$this->context->controller->addCSS($this->_path.'posproductcategory.css', 'all');
		$this->context->controller->addJS($this->_path.'pos.bxslider.min.js');
               // $this->context->controller->addJS($this->_path.'productscategory.js');
		//$this->context->controller->addJqueryPlugin('serialScroll');
	}

	public function hookAddProduct($params)
	{
		$this->_clearCache('productscategory.tpl');
	}

	public function hookUpdateProduct($params)
	{
		$this->_clearCache('productscategory.tpl');
	}

	public function hookDeleteProduct($params)
	{
		$this->_clearCache('productscategory.tpl');
	}
}
