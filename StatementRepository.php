<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\Repository\Api;

use Rhumsaa\Uuid\Uuid;
use Xabbuh\XApi\Common\Exception\NotFoundException;
use Xabbuh\XApi\Model\Actor;
use Xabbuh\XApi\Model\Statement;
use Xabbuh\XApi\Model\StatementId;
use Xabbuh\XApi\Model\StatementsFilter;
use XApi\Repository\Api\Mapping\MappedStatement;

/**
 * {@link Statement} repository.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
abstract class StatementRepository implements StatementRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    final public function findStatementById(StatementId $statementId, Actor $authority = null)
    {
        $criteria = array('id' => $statementId->getValue());

        if (null !== $authority) {
            $criteria['authority'] = $authority;
        }

        $mappedStatement = $this->findMappedStatement($criteria);

        if (null === $mappedStatement) {
            throw new NotFoundException();
        }

        $statement = $mappedStatement->getModel();

        if ($statement->isVoidStatement()) {
            throw new NotFoundException();
        }

        return $statement;
    }

    /**
     * {@inheritdoc}
     */
    final public function findVoidedStatementById(StatementId $voidedStatementId, Actor $authority = null)
    {
        $criteria = array('id' => $voidedStatementId->getValue());

        if (null !== $authority) {
            $criteria['authority'] = $authority;
        }

        $mappedStatement = $this->findMappedStatement($criteria);

        if (null === $mappedStatement) {
            throw new NotFoundException();
        }

        $statement = $mappedStatement->getModel();

        if (!$statement->isVoidStatement()) {
            throw new NotFoundException();
        }

        return $statement;
    }

    /**
     * {@inheritdoc}
     */
    final public function findStatementsBy(StatementsFilter $criteria, Actor $authority = null)
    {
        $criteria = $criteria->getFilter();

        if (null !== $authority) {
            $criteria['authority'] = $authority;
        }

        $mappedStatements = $this->findMappedStatements($criteria);
        $statements = array();

        foreach ($mappedStatements as $mappedStatement) {
            $statements[] = $mappedStatement->getModel();
        }

        return $statements;
    }

    /**
     * {@inheritdoc}
     */
    final public function storeStatement(Statement $statement, $flush = true)
    {
        $uuid = $statement->getId()->getValue();
        $mappedStatement = MappedStatement::createFromModel($statement);
        $mappedStatement->stored = new \DateTime();

        if (null === $uuid) {
            $uuid = Uuid::uuid4()->toString();
            $mappedStatement->id = $uuid;
        }

        $this->storeMappedStatement($mappedStatement, $flush);

        return StatementId::fromString($uuid);
    }

    /**
     * Loads a certain {@link MappedStatement} from the data storage.
     *
     * @param array $criteria Criteria to filter a statement by
     *
     * @return MappedStatement The mapped statement
     */
    abstract protected function findMappedStatement(array $criteria);

    /**
     * Loads {@link MappedStatement mapped statements} from the data storage.
     *
     * @param array $criteria Criteria to filter statements by
     *
     * @return MappedStatement[] The mapped statements
     */
    abstract protected function findMappedStatements(array $criteria);

    /**
     * Writes a {@link MappedStatement mapped statement} to the underlying
     * data storage.
     *
     * @param MappedStatement $mappedStatement The statement to store
     * @param bool            $flush           Whether or not to flush the managed
     *                                         objects immediately (i.e. write
     *                                         them to the data storage)
     */
    abstract protected function storeMappedStatement(MappedStatement $mappedStatement, $flush);
}
