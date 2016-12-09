<?php

/**
 * TechDivision\Import\Product\Variant\Services\ProductVariantProcessor
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

namespace TechDivision\Import\Product\Variant\Services;

/**
 * A SLSB providing methods to load product data using a PDO connection.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */
class ProductVariantProcessor implements ProductVariantProcessorInterface
{

    /**
     * A PDO connection initialized with the values from the Doctrine EntityManager.
     *
     * @var \PDO
     */
    protected $connection;

    /**
     * The repository to access EAV attribute set.
     *
     * @var \TechDivision\Import\Product\Repositories\EavAttributeSetRepository
     */
    protected $eavAttributeSetRepository;

    /**
     * The repository to access EAV attribute option values.
     *
     * @var \TechDivision\Import\Product\Repositories\EavAttributeOptionValueRepository
     */
    protected $eavAttributeOptionValueRepository;

    /**
     * The action for product relation CRUD methods.
     *
     * @var \TechDivision\Import\Product\Variant\Actions\ProductRelationAction
     */
    protected $productRelationAction;

    /**
     * The action for product super attribute CRUD methods.
     *
     * @var \TechDivision\Import\Product\Variant\Actions\ProductSuperAttributeAction
     */
    protected $productSuperAttributeAction;

    /**
     * The action for product super attribute label CRUD methods.
     *
     * @var \TechDivision\Import\Product\Variant\Actions\ProductSuperAttributeLabelAction
     */
    protected $productSuperAttributeLabelAction;

    /**
     * The action for product super link CRUD methods.
     *
     * @var \TechDivision\Import\Product\Variant\Actions\ProductSuperLinkAction
     */
    protected $productSuperLinkAction;

    /**
     * Set's the passed connection.
     *
     * @param \PDO $connection The connection to set
     *
     * @return void
     */
    public function setConnection(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return's the connection.
     *
     * @return \PDO The connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Turns off autocommit mode. While autocommit mode is turned off, changes made to the database via the PDO
     * object instance are not committed until you end the transaction by calling ProductProcessor::commit().
     * Calling ProductProcessor::rollBack() will roll back all changes to the database and return the connection
     * to autocommit mode.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commits a transaction, returning the database connection to autocommit mode until the next call to
     * ProductProcessor::beginTransaction() starts a new transaction.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.commit.php
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by ProductProcessor::beginTransaction().
     *
     * If the database was set to autocommit mode, this function will restore autocommit mode after it has
     * rolled back the transaction.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition
     * language (DDL) statement such as DROP TABLE or CREATE TABLE is issued within a transaction. The implicit
     * COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }

    /**
     * Set's the repository to access EAV attributes.
     *
     * @param \TechDivision\Import\Product\Repositories\EavAttributeRepository $eavAttributeRepository The repository to access EAV attributes
     *
     * @return void
     */
    public function setEavAttributeRepository($eavAttributeRepository)
    {
        $this->eavAttributeRepository = $eavAttributeRepository;
    }

    /**
     * Return's the repository to access EAV attributes.
     *
     * @return \TechDivision\Import\Product\Repositories\EavAttributeRepository The repository instance
     */
    public function getEavAttributeRepository()
    {
        return $this->eavAttributeRepository;
    }

    /**
     * Set's the repository to access EAV attribute option values.
     *
     * @param \TechDivision\Import\Product\Repositories\EavAttributeOptionValueRepository $eavAttributeOptionValueRepository The repository to access EAV attribute option values
     *
     * @return void
     */
    public function setEavAttributeOptionValueRepository($eavAttributeOptionValueRepository)
    {
        $this->eavAttributeOptionValueRepository = $eavAttributeOptionValueRepository;
    }

    /**
     * Return's the repository to access EAV attribute option values.
     *
     * @return \TechDivision\Import\Product\Repositories\EavAttributeOptionValueRepository The repository instance
     */
    public function getEavAttributeOptionValueRepository()
    {
        return $this->eavAttributeOptionValueRepository;
    }

    /**
     * Set's the action with the product relation CRUD methods.
     *
     * @param \TechDivision\Import\Product\Variant\Actions\ProductRelationAction $productRelationAction The action with the product relation CRUD methods
     *
     * @return void
     */
    public function setProductRelationAction($productRelationAction)
    {
        $this->productRelationAction = $productRelationAction;
    }

    /**
     * Return's the action with the product relation CRUD methods.
     *
     * @return \TechDivision\Import\Product\Variant\Actions\ProductRelationAction The action instance
     */
    public function getProductRelationAction()
    {
        return $this->productRelationAction;
    }

    /**
     * Set's the action with the product super attribute CRUD methods.
     *
     * @param \TechDivision\Import\Product\Variant\Actions\ProductSuperAttributeAction $productSuperAttributeAction The action with the product super attribute CRUD methods
     *
     * @return void
     */
    public function setProductSuperAttributeAction($productSuperAttributeAction)
    {
        $this->productSuperAttributeAction = $productSuperAttributeAction;
    }

    /**
     * Return's the action with the product super attribute CRUD methods.
     *
     * @return \TechDivision\Import\Product\Variant\Actions\ProductSuperAttributeAction The action instance
     */
    public function getProductSuperAttributeAction()
    {
        return $this->productSuperAttributeAction;
    }

    /**
     * Set's the action with the product super attribute label CRUD methods.
     *
     * @param \TechDivision\Import\Product\Variant\Actions\ProductSuperAttributeLabelAction $productSuperAttributeLabelAction The action with the product super attribute label CRUD methods
     *
     * @return void
     */
    public function setProductSuperAttributeLabelAction($productSuperAttributeLabelAction)
    {
        $this->productSuperAttributeLabelAction = $productSuperAttributeLabelAction;
    }

    /**
     * Return's the action with the product super attribute label CRUD methods.
     *
     * @return \TechDivision\Import\Product\Variant\Actions\ProductSuperAttributeLabelAction The action instance
     */
    public function getProductSuperAttributeLabelAction()
    {
        return $this->productSuperAttributeLabelAction;
    }

    /**
     * Set's the action with the product super link CRUD methods.
     *
     * @param \TechDivision\Import\Product\Variant\Actions\ProductSuperLinkAction $productSuperLinkAction The action with the product super link CRUD methods
     *
     * @return void
     */
    public function setProductSuperLinkAction($productSuperLinkAction)
    {
        $this->productSuperLinkAction = $productSuperLinkAction;
    }

    /**
     * Return's the action with the product super link CRUD methods.
     *
     * @return \TechDivision\Import\Product\Variant\Actions\ProductSuperLinkAction The action instance
     */
    public function getProductSuperLinkAction()
    {
        return $this->productSuperLinkAction;
    }

    /**
     * Return's the attribute option value with the passed value and store ID.
     *
     * @param mixed   $value   The option value
     * @param integer $storeId The ID of the store
     *
     * @return array|boolean The attribute option value instance
     */
    public function getEavAttributeOptionValueByOptionValueAndStoreId($value, $storeId)
    {
        return $this->getEavAttributeOptionValueRepository()->findEavAttributeOptionValueByOptionValueAndStoreId($value, $storeId);
    }

    /**
     * Return's the first EAV attribute for the passed option value and store ID.
     *
     * @param string $optionValue The option value of the EAV attributes
     * @param string $storeId     The store ID of the EAV attribues
     *
     * @return array The array with the EAV attribute
     */
    public function getEavAttributeByOptionValueAndStoreId($optionValue, $storeId)
    {
        return $this->getEavAttributeRepository()->findOneByOptionValueAndStoreId($optionValue, $storeId);
    }

    /**
     * Persist's the passed product relation data and return's the ID.
     *
     * @param array $productRelation The product relation data to persist
     *
     * @return void
     */
    public function persistProductRelation($productRelation)
    {
        return $this->getProductRelationAction()->persist($productRelation);
    }

    /**
     * Persist's the passed product super link data and return's the ID.
     *
     * @param array $productSuperLink The product super link data to persist
     *
     * @return void
     */
    public function persistProductSuperLink($productSuperLink)
    {
        return $this->getProductSuperLinkAction()->persist($productSuperLink);
    }

    /**
     * Persist's the passed product super attribute data and return's the ID.
     *
     * @param array $productSuperAttribute The product super attribute data to persist
     *
     * @return string The ID of the persisted product super attribute entity
     */
    public function persistProductSuperAttribute($productSuperAttribute)
    {
        return $this->getProductSuperAttributeAction()->persist($productSuperAttribute);
    }

    /**
     * Persist's the passed product super attribute label data and return's the ID.
     *
     * @param array $productSuperAttributeLabel The product super attribute label data to persist
     *
     * @return void
     */
    public function persistProductSuperAttributeLabel($productSuperAttributeLabel)
    {
        return $this->getProductSuperAttributeLabelAction()->persist($productSuperAttributeLabel);
    }
}
