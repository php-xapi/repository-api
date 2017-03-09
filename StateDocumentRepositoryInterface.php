<?php

namespace XApi\Repository\Api;

use Xabbuh\XApi\Common\Exception\NotFoundException;
use Xabbuh\XApi\Model\StateDocument;
use Xabbuh\XApi\Model\StateDocumentsFilter;

/**
 * Public API of an Experience API (xAPI) {@link StateDocument} repository.
 *
 * @author Jérôme Parmentier <jerome.parmentier@acensi.fr>
 */
interface StateDocumentRepositoryInterface
{
    /**
     * Finds a {@link StateDocument} by state id.
     *
     * @param string               $stateId  The state id to filter by
     * @param StateDocumentsFilter $criteria additional criteria to filter by
     *
     * @throws NotFoundException if no State document with the given criterias does exist
     *
     * @return StateDocument The state document
     */
    public function findStateDocumentBy($stateId, StateDocumentsFilter $criteria);

    /**
     * Finds a collection of {@link StateDocument State documents} filtered by the given
     * criteria.
     *
     * @param StateDocumentsFilter $criteria The criteria to filter by
     *
     * @return StateDocument[] The state documents
     */
    public function findStateDocumentsBy(StateDocumentsFilter $criteria);

    /**
     * Writes a {@link StateDocument} to the underlying data storage.
     *
     * @param StateDocument $stateDocument The state document to store
     * @param bool          $flush         Whether or not to flush the managed objects
     *                                     immediately (i.e. write them to the data
     *                                     storage)
     */
    public function storeStateDocument(StateDocument $stateDocument, $flush = true);

    /**
     * Delete a {@link StateDocument} from the underlying data storage.
     *
     * @param StateDocument $stateDocument The state document to delete
     * @param bool          $flush         Whether or not to flush the managed objects
     *                                     immediately (i.e. delete them from the data
     *                                     storage)
     */
    public function deleteStateDocument(StateDocument $stateDocument, $flush = true);
}
