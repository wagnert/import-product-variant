<?php

/**
 * TechDivision\Import\Product\Variant\Actions\Processors\ProductSuperAttributeUpdateProcessor
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

namespace TechDivision\Import\Product\Variant\Actions\Processors;

use TechDivision\Import\Product\Variant\Utils\MemberNames;
use TechDivision\Import\Actions\Processors\AbstractUpdateProcessor;

/**
 * The product super attribute update processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */
class ProductSuperAttributeUpdateProcessor extends AbstractUpdateProcessor
{

    /**
     * Return's the array with the SQL statements that has to be prepared.
     *
     * @return array The SQL statements to be prepared
     * @see \TechDivision\Import\Actions\Processors\AbstractBaseProcessor::getStatements()
     */
    protected function getStatements()
    {

        // load the utility class name
        $utilityClassName = $this->getUtilityClassName();

        // return the array with the SQL statements that has to be prepared
        return array(
            $utilityClassName::UPDATE_PRODUCT_SUPER_ATTRIBUTE => $utilityClassName::UPDATE_PRODUCT_SUPER_ATTRIBUTE
        );
    }

    /**
     * Persist's the passed row.
     *
     * @param array       $row  The row to persist
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The last inserted ID
     */
    public function execute($row, $name = null)
    {
        parent::execute($row, $name);
        return $row[MemberNames::PRODUCT_SUPER_ATTRIBUTE_ID];
    }
}