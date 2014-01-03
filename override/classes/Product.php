<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @deprecated 1.5.0.1
 */
define('_CUSTOMIZE_FILE_', 0);
/**
 * @deprecated 1.5.0.1
 */
define('_CUSTOMIZE_TEXTFIELD_', 1);

class Product extends ProductCore
{
	/** @var string Tax name */
	public $tax_name;

	/** @var string Tax rate */
	public $tax_rate;

	/** @var integer Manufacturer id */
	public $id_manufacturer;

	/** @var integer Supplier id */
	public $id_supplier;

	/** @var integer default Category id */
	public $id_category_default;

	/** @var integer default Shop id */
	public $id_shop_default;

	/** @var string Manufacturer name */
	public $manufacturer_name;

	/** @var string Supplier name */
	public $supplier_name;

	/** @var string Name */
	public $name;

	/** @var string Long description */
	public $description;

	/** @var string Short description */
	public $description_short;

	/** @var integer Quantity available */
	public $quantity = 0;

	/** @var integer Minimal quantity for add to cart */
	public $minimal_quantity = 1;

	/** @var string available_now */
	public $available_now;

	/** @var string available_later */
	public $available_later;

	/** @var float Price in euros */
	public $price = 0;

	/** @var float Additional shipping cost */
	public $additional_shipping_cost = 0;

	/** @var float Wholesale Price in euros */
	public $wholesale_price = 0;

	/** @var boolean on_sale */
	public $on_sale = false;

	/** @var boolean online_only */
	public $online_only = false;

	/** @var string unity */
	public $unity = null;

		/** @var float price for product's unity */
	public $unit_price;

		/** @var float price for product's unity ratio */
	public $unit_price_ratio = 0;

	/** @var float Ecotax */
	public $ecotax = 0;

	/** @var string Reference */
	public $reference;

	/** @var string Supplier Reference */
	public $supplier_reference;

	/** @var string Location */
	public $location;

	/** @var string Width in default width unit */
	public $width = 0;

	/** @var string Height in default height unit */
	public $height = 0;

	/** @var string Depth in default depth unit */
	public $depth = 0;

	/** @var string Weight in default weight unit */
	public $weight = 0;

	/** @var string Ean-13 barcode */
	public $ean13;

	/** @var string Upc barcode */
	public $upc;

	/** @var string Friendly URL */
	public $link_rewrite;

	/** @var string Meta tag description */
	public $meta_description;

	/** @var string Meta tag keywords */
	public $meta_keywords;

	/** @var string Meta tag title */
	public $meta_title;

	/** @var boolean Product statuts */
	public $quantity_discount = 0;

	/** @var boolean Product customization */
	public $customizable;

	/** @var boolean Product is new */
	public $new = null;

	/** @var integer Number of uploadable files (concerning customizable products) */
	public $uploadable_files;

	/** @var int Number of text fields */
	public $text_fields;

	/** @var boolean Product statuts */
	public $active = true;
	
	/** @var boolean Product statuts */
	public $redirect_type = '';
	
	/** @var boolean Product statuts */
	public $id_product_redirected = 0;
		
	/** @var boolean Product available for order */
	public $available_for_order = true;

	/** @var string Object available order date */
	public $available_date = '0000-00-00';

	/** @var enum Product condition (new, used, refurbished) */
	public $condition;

	/** @var boolean Show price of Product */
	public $show_price = true;

	/** @var boolean is the product indexed in the search index? */
	public $indexed = 0;

	/** @var string ENUM('both', 'catalog', 'search', 'none') front office visibility */
	public $visibility;

	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
	public $date_upd;
        
        /** @var int Number of Tree Type */
	public $id_tree_type;

	/*** @var array Tags */
	public $tags;

	public $id_tax_rules_group = 1;

	/**
	 * We keep this variable for retrocompatibility for themes
	 * @deprecated 1.5.0
	 */
	public $id_color_default = 0;

	/**
	 * @since 1.5.0
	 * @var boolean Tells if the product uses the advanced stock management
	 */
	public $advanced_stock_management = 0;
	public $out_of_stock;
	public $depends_on_stock;

	public $isFullyLoaded = false;

	public $cache_is_pack;
	public $cache_has_attachments;
	public $is_virtual;
	public $cache_default_attribute;

	/**
	 * @var string If product is populated, this property contain the rewrite link of the default category
	 */
	public $category;

	public static $_taxCalculationMethod = null;
	protected static $_prices = array();
	protected static $_pricesLevel2 = array();
	protected static $_incat = array();

	/**
	 * @since 1.5.6.1
	 * @var array $_cart_quantity is deprecated since 1.5.6.1
	 */
	protected static $_cart_quantity = array();

	protected static $_tax_rules_group = array();
	protected static $_cacheFeatures = array();
	protected static $_frontFeaturesCache = array();
	protected static $producPropertiesCache = array();

	/** @var array cache stock data in getStock() method */
	protected static $cacheStock = array();

	public static $definition = array(
		'table' => 'product',
		'primary' => 'id_product',
		'multilang' => true,
		'multilang_shop' => true,
		'fields' => array(
			// Classic fields
			'id_shop_default' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_manufacturer' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_supplier' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'reference' => 					array('type' => self::TYPE_STRING, 'validate' => 'isReference', 'size' => 32),
			'supplier_reference' => 		array('type' => self::TYPE_STRING, 'validate' => 'isReference', 'size' => 32),
			'location' => 					array('type' => self::TYPE_STRING, 'validate' => 'isReference', 'size' => 64),
			'width' => 						array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'height' => 					array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'depth' => 						array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'weight' => 					array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'quantity_discount' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'ean13' => 						array('type' => self::TYPE_STRING, 'validate' => 'isEan13', 'size' => 13),
			'upc' => 						array('type' => self::TYPE_STRING, 'validate' => 'isUpc', 'size' => 12),
			'cache_is_pack' => 				array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'cache_has_attachments' => 		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'is_virtual' => 				array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),

			/* Shop fields */
			'id_category_default' => 		array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedId'),
			'id_tax_rules_group' => 		array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedId'),
			'on_sale' => 					array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'online_only' => 				array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'ecotax' => 					array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice'),
			'minimal_quantity' => 			array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),
			'price' => 						array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice', 'required' => true),
			'wholesale_price' => 			array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice'),
			'unity' => 						array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isString'),
			'unit_price_ratio' => 			array('type' => self::TYPE_FLOAT, 'shop' => true),
			'additional_shipping_cost' => 	array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice'),
			'customizable' => 				array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),
			'text_fields' => 				array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),
			'uploadable_files' => 			array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),
			'active' => 					array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'redirect_type' => 				array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isString'),
			'id_product_redirected' => 		array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedId'),
			'available_for_order' => 		array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'available_date' => 			array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDateFormat'),
			'condition' => 					array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isGenericName', 'values' => array('new', 'used', 'refurbished'), 'default' => 'new'),
			'show_price' => 				array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'indexed' => 					array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'visibility' => 				array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isProductVisibility', 'values' => array('both', 'catalog', 'search', 'none'), 'default' => 'both'),
			'cache_default_attribute' => 	array('type' => self::TYPE_INT, 'shop' => true),
			'advanced_stock_management' => 	array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'date_add' => 					array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDateFormat'),
			'date_upd' => 					array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDateFormat'),
                        'id_tree_type' =>       			array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedId'),

			/* Lang fields */
			'meta_description' => 			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'meta_keywords' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'meta_title' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 128),
			'link_rewrite' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128),
			'name' => 						array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
			'description' => 				array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
			'description_short' => 			array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
			'available_now' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'available_later' => 			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'IsGenericName', 'size' => 255),
		),
		'associations' => array(
			'manufacturer' => 				array('type' => self::HAS_ONE),
			'supplier' => 					array('type' => self::HAS_ONE),
			'default_category' => 			array('type' => self::HAS_ONE, 'field' => 'id_category_default', 'object' => 'Category'),
			'tax_rules_group' => 			array('type' => self::HAS_ONE),
			'categories' =>					array('type' => self::HAS_MANY, 'field' => 'id_category', 'object' => 'Category', 'association' => 'category_product'),
			'stock_availables' =>			array('type' => self::HAS_MANY, 'field' => 'id_stock_available', 'object' => 'StockAvailable', 'association' => 'stock_availables'),
		),
	);

	protected $webserviceParameters = array(
		'objectMethods' => array(
			'add' => 'addWs',
			'update' => 'updateWs'
		),
		'objectNodeNames' => 'products',
		'fields' => array(
			'id_manufacturer' => array(
				'xlink_resource' => 'manufacturers'
			),
			'id_supplier' => array(
				'xlink_resource' => 'suppliers'
			),
			'id_category_default' => array(
				'xlink_resource' => 'categories'
			),
			'new' => array(),
			'cache_default_attribute' => array(),
			'id_default_image' => array(
				'getter' => 'getCoverWs',
				'setter' => 'setCoverWs',
				'xlink_resource' => array(
					'resourceName' => 'images',
					'subResourceName' => 'products'
				)
			),
			'id_default_combination' => array(
				'getter' => 'getWsDefaultCombination',
				'setter' => 'setWsDefaultCombination',
				'xlink_resource' => array(
					'resourceName' => 'combinations'
				)
			),
			'id_tax_rules_group' => array(
				'xlink_resource' => array(
					'resourceName' => 'tax_rule_groups'
				)
			),
			'position_in_category' => array(
				'getter' => 'getWsPositionInCategory',
				'setter' => false
			),
			'manufacturer_name' => array(
				'getter' => 'getWsManufacturerName',
				'setter' => false
			),
			'quantity' => array(
				'getter' => false,
				'setter' => false
			),
			'type' => array(
				'getter' => 'getWsType',
				'setter' => 'setWsType',
			),
		),
		'associations' => array(
			'categories' => array(
				'resource' => 'category',
				'fields' => array(
					'id' => array('required' => true),
				)
			),
			'images' => array(
				'resource' => 'image',
				'fields' => array('id' => array())
			),
			'combinations' => array(
				'resource' => 'combinations',
				'fields' => array(
					'id' => array('required' => true),
				)
			),
			'product_option_values' => array(
				'resource' => 'product_options_values',
				'fields' => array(
					'id' => array('required' => true),
				)
			),
			'product_features' => array(
				'resource' => 'product_feature',
				'fields' => array(
					'id' => array('required' => true),
					'custom' => array('required' => false),
					'id_feature_value' => array(
						'required' => true,
						'xlink_resource' => 'product_feature_values'
					),
				)
			),
			'tags' => array('resource' => 'tag',
				'fields' => array(
					'id' => array('required' => true),
			)),
			'stock_availables' => array('resource' => 'stock_available',
				'fields' => array(
					'id' => array('required' => true),
					'id_product_attribute' => array('required' => true),
				),
				'setter' => false
			),
			'accessories' => array(
				'resource' => 'product',
				'fields' => array(
					'id' => array(
						'required' => true,
						'xlink_resource' => 'product'),
				)
			),
			'product_bundle' => array(
				'resource' => 'products',
				'fields' => array(
					'id' => array('required' => true),
					'quantity' => array(),
				),
			),
		),
	);

	const CUSTOMIZE_FILE = 0;
	const CUSTOMIZE_TEXTFIELD = 1;

	/**
	 * Note:  prefix is "PTYPE" because TYPE_ is used in ObjectModel (definition)
	 */
	const PTYPE_SIMPLE = 0;
	const PTYPE_PACK = 1;
	const PTYPE_VIRTUAL = 2;

	public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_product, $id_lang, $id_shop);
		if (!$context)
			$context = Context::getContext();

		if ($full && $this->id)
		{
			$this->isFullyLoaded = $full;
			$this->tax_name = 'deprecated'; // The applicable tax may be BOTH the product one AND the state one (moreover this variable is some deadcode)
			$this->manufacturer_name = Manufacturer::getNameById((int)$this->id_manufacturer);
			$this->supplier_name = Supplier::getNameById((int)$this->id_supplier);
			$address = null;
			if (is_object($context->cart) && $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')} != null)
				$address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};

			$this->tax_rate = $this->getTaxesRate(new Address($address));

			$this->new = $this->isNew();

			// keep base price
			$this->base_price = $this->price;

			$this->price = Product::getPriceStatic((int)$this->id, false, null, 6, null, false, true, 1, false, null, null, null, $this->specificPrice);
			$this->unit_price = ($this->unit_price_ratio != 0  ? $this->price / $this->unit_price_ratio : 0);
			if ($this->id)
				$this->tags = Tag::getProductTags((int)$this->id);

			$this->loadStockData();
		}

		if ($this->id_category_default)
			$this->category = Category::getLinkRewrite((int)$this->id_category_default, (int)$id_lang);
	}

	/**
	 * @see ObjectModel::getFieldsShop()
	 * @return array
	 */
	public function getFieldsShop()
	{
		$fields = parent::getFieldsShop();
		if (is_null($this->update_fields) || (!empty($this->update_fields['price']) && !empty($this->update_fields['unit_price'])))
		$fields['unit_price_ratio'] = (float)$this->unit_price > 0 ? $this->price / $this->unit_price : 0;

		return $fields;
	}

	public function add($autodate = true, $null_values = false)
	{
		if (!parent::add($autodate, $null_values))
			return false;
			
		if ($this->getType() == Product::PTYPE_VIRTUAL)
			StockAvailable::setProductOutOfStock((int)$this->id, 1);
		else
			StockAvailable::setProductOutOfStock((int)$this->id, 2);

		$this->setGroupReduction();
		Hook::exec('actionProductSave', array('id_product' => $this->id));
		return true;
	}

	public function update($null_values = false)
	{
		$return = parent::update($null_values);
		$this->setGroupReduction();
		Hook::exec('actionProductSave', array('id_product' => $this->id));
		return $return;
	}

}
