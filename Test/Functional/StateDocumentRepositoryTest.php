<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\Repository\Api\Test\Functional;

use Xabbuh\XApi\DataFixtures\ActivityFixtures;
use Xabbuh\XApi\DataFixtures\ActorFixtures;
use Xabbuh\XApi\DataFixtures\DocumentFixtures;
use Xabbuh\XApi\Model\StateDocument;
use Xabbuh\XApi\Model\StateDocumentsFilter;
use XApi\Repository\Api\StateDocumentRepositoryInterface;

/**
 * @author Jérôme Parmentier <jerome.parmentier@acensi.fr>
 */
abstract class StateDocumentRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StateDocumentRepositoryInterface
     */
    private $stateDocumentRepository;

    protected function setUp()
    {
        $this->stateDocumentRepository = $this->createStateDocumentRepositoryInterface();
        $this->cleanDatabase();
    }

    protected function tearDown()
    {
        $this->cleanDatabase();
    }

    /**
     * @expectedException \Xabbuh\XApi\Common\Exception\NotFoundException
     */
    public function testFetchingNonExistingStateDocumentThrowsException()
    {
        $criteria = new StateDocumentsFilter();
        $criteria
            ->byActivity(ActivityFixtures::getIdActivity())
            ->byAgent(ActorFixtures::getTypicalAgent());

        $this->stateDocumentRepository->find('unknown-state-id', $criteria);
    }

    /**
     * @dataProvider getStateDocument
     */
    public function testCreatedStateDocumentCanBeRetrievedByOriginal(StateDocument $stateDocument)
    {
        $this->stateDocumentRepository->save($stateDocument);

        $criteria = new StateDocumentsFilter();
        $criteria
            ->byActivity($stateDocument->getState()->getActivity())
            ->byAgent($stateDocument->getState()->getActor());

        $fetchedStateDocument = $this->stateDocumentRepository->find($stateDocument->getState()->getStateId(), $criteria);

        $this->assertTrue($stateDocument->equals($fetchedStateDocument));
    }

    /**
     * @dataProvider getStateDocument
     * @expectedException \Xabbuh\XApi\Common\Exception\NotFoundException
     */
    public function testDeletedStatementIsDeleted(StateDocument $stateDocument)
    {
        $this->stateDocumentRepository->save($stateDocument);
        $this->stateDocumentRepository->delete($stateDocument);

        $criteria = new StateDocumentsFilter();
        $criteria
            ->byActivity($stateDocument->getState()->getActivity())
            ->byAgent($stateDocument->getState()->getActor());

        $this->stateDocumentRepository->find($stateDocument->getState()->getStateId(), $criteria);
    }

    public function getStateDocument()
    {
        return array(DocumentFixtures::getStateDocument());
    }

    abstract protected function createStateDocumentRepositoryInterface();

    abstract protected function cleanDatabase();
}
