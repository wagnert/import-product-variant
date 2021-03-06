<?php

/**
 * TechDivision\Import\Product\Variant\Repositories\SqlStatementRepository
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

namespace TechDivision\Import\Product\Variant\Repositories;

use TechDivision\Import\Product\Variant\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends \TechDivision\Import\Product\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::PRODUCT_SUPER_LINK =>
            'SELECT *
               FROM catalog_product_super_link
              WHERE product_id = :product_id
                AND parent_id = :parent_id',
        SqlStatementKeys::PRODUCT_SUPER_ATTRIBUTE =>
            'SELECT *
               FROM catalog_product_super_attribute
              WHERE product_id = :product_id
                AND attribute_id = :attribute_id',
        SqlStatementKeys::PRODUCT_SUPER_ATTRIBUTE_LABEL =>
            'SELECT *
               FROM catalog_product_super_attribute_label
              WHERE product_super_attribute_id = :product_super_attribute_id
                AND store_id = :store_id',
        SqlStatementKeys::CREATE_PRODUCT_SUPER_LINK =>
            'INSERT
               INTO catalog_product_super_link
                    (product_id,
                     parent_id)
             VALUES (:product_id,
                     :parent_id)',
        SqlStatementKeys::CREATE_PRODUCT_SUPER_ATTRIBUTE =>
            'INSERT
               INTO catalog_product_super_attribute
                    (product_id,
                     attribute_id,
                     position)
             VALUES (:product_id,
                     :attribute_id,
                     :position)',
        SqlStatementKeys::UPDATE_PRODUCT_SUPER_ATTRIBUTE =>
            'UPDATE catalog_product_super_attribute
                SET product_id = :product_id,
                    attribute_id = :attribute_id,
                    position = :position
              WHERE product_super_attribute_id = :product_super_attribute_id',
        SqlStatementKeys::CREATE_PRODUCT_SUPER_ATTRIBUTE_LABEL =>
            'INSERT
                INTO catalog_product_super_attribute_label
                     (product_super_attribute_id,
                      store_id,
                      use_default,
                      value)
              VALUES (:product_super_attribute_id,
                      :store_id,
                      :use_default,
                      :value)',
        SqlStatementKeys::UPDATE_PRODUCT_SUPER_ATTRIBUTE_LABEL =>
            'UPDATE catalog_product_super_attribute_label
                SET product_super_attribute_id = :product_super_attribute_id,
                    store_id = :store_id,
                    use_default = :use_default,
                    value = :value
              WHERE value_id = :value_id'
    );

    /**
     * Initialize the the SQL statements.
     */
    public function __construct()
    {

        // call the parent constructor
        parent::__construct();

        // merge the class statements
        foreach ($this->statements as $key => $statement) {
            $this->preparedStatements[$key] = $statement;
        }
    }
}
