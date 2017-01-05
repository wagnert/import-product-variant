<?php

/**
 * TechDivision\Import\Product\Variant\Observers\VariantSuperAttributeUpdateObserver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Variant\Observers;

use TechDivision\Import\Product\Variant\Utils\MemberNames;

/**
 * Oberserver that provides functionality for the product variant super attribute labels add/update operation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */
class VariantSuperAttributeUpdateObserver extends VariantSuperAttributeObserver
{

    /**
     * Initialize the product super attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The product super attribute attributes
     *
     * @return array The initialized product super attribute
     */
    protected function initializeProductSuperAttribute(array $attr)
    {

        // load product/attribute ID
        $productId = $attr[MemberNames::PRODUCT_ID];
        $attributeId = $attr[MemberNames::ATTRIBUTE_ID];

        // query whether or not, the product super attribute already exists
        if ($entity = $this->loadProductSuperAttribute($productId, $attributeId)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Initialize the product super attribute label with the passed attributes and returns an instance.
     *
     * @param array $attr The product super attribute label attributes
     *
     * @return array The initialized product super attribute label
     */
    protected function initializeProductSuperAttributeLabel(array $attr)
    {

        // load product super attribute/store ID
        $storeId = $attr[MemberNames::STORE_ID];
        $productSuperAttributeId = $attr[MemberNames::PRODUCT_SUPER_ATTRIBUTE_ID];

        // query whether or not, the product super attribute label already exists
        if ($entity = $this->loadProductSuperAttributeLabel($productSuperAttributeId, $storeId)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Load's the product super attribute with the passed product/attribute ID.
     *
     * @param integer $productId   The entity ID of the product super attribute's product
     * @param integer $attributeId The attribute ID of the product super attributes attribute
     *
     * @return array The product super attribute
     */
    protected function loadProductSuperAttribute($productId, $attributeId)
    {
        return $this->getSubject()->loadProductSuperAttribute($productId, $attributeId);
    }

    /**
     * Load's the product super attribute label with the passed product super attribute/store ID.
     *
     * @param integer $productSuperAttributeId The product super attribute ID of the product super attribute label
     * @param integer $storeId                 The store ID of the product super attribute label
     *
     * @return array The product super attribute label
     */
    protected function loadProductSuperAttributeLabel($productSuperAttributeId, $storeId)
    {
        return $this->getSubject()->loadProductSuperAttributeLabel($productSuperAttributeId, $storeId);
    }
}
