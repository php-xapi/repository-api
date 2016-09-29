UPGRADE
=======

Upgrading from 0.2 to 0.3
-------------------------

* The public API now uses `StatementId` instances instead of strings to carry
  information about statement ids. This means changes to the following methods:

  * `StatementRepositoryInterface::findStatementById()`: The `$statementId`
    argument is now type hinted with `StatementId`.

  * `StatementRepositoryInterface::findVoidedStatementById()`: The `$voidedStatementId`
    argument is now type hinted with `StatementId`.

  * `StatementRepositoryInterface::storeStatement()`: The method returns a
    `StatementId` instance instead of a string.

* The requirements for `php-xapi/model` and `php-xapi/test-fixtures` have
  been bumped to `^1.0` to make use of their stable releases.

Upgrading from 0.1 to 0.2
-------------------------

The base namespace of all classes was changed from `Xabbuh\XApi\Storage\Api` to
`XApi\Repository\Api`.
