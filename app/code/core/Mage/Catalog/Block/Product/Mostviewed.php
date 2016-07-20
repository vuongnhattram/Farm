<?php
/**
 * Created by PhpStorm.
 * User: baoan
 * Date: 7/21/2016
 * Time: 2:58 AM
 */
//Fetch attribute set id by attribute set name
$attrSetName = 'baiviet';
$attributeSetId = Mage::getModel('eav/entity_attribute_set')
    ->load($attrSetName, 'attribute_set_name')
    ->getAttributeSetId();
$products =$this->getProductCollection()
    ->addFieldToFilter('attribute_set_id', $attributeSetId)->setPageSize();

class Mage_Catalog_Block_Product_Mostviewed extends Mage_Catalog_Block_Product_Abstract{
    public function __construct(){
        parent::__construct();
        $storeId    = Mage::app()->getStore()->getId();
        $products = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty()
            ->addAttributeToSelect('*')
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->addViewsCount();
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);

        $products->setPageSize(5)->setCurPage(1);
        $this->setProductCollection($products);
    }
}