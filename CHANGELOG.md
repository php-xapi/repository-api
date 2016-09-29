CHANGELOG
=========

0.3.0
-----

* The public API now uses `StatementId` instances instead of strings to carry
  information about statement ids. This means changes to the following methods:

  * `StatementRepositoryInterface::findStatementById()`: The `$statementId`
    argument is now type hinted with `StatementId`.

  * `StatementRepositoryInterface::findVoidedStatementById()`: The `$voidedStatementId`
    argument is now type hinted with `StatementId`.

  * `StatementRepositoryInterface::storeStatement()`: The method returns a
    `StatementId` instance instead of a string.

* Added a `StatementRepositoryInterface` that defines the public API of a
  statement repository. You can still extend the base `StatementRepository`
  class or provide your own implementation of this new interface.

* The requirements for `php-xapi/model` and `php-xapi/test-fixtures` have
  been bumped to `^1.0` to make use of their stable releases.

0.2.0
-----

* changed base namespace of all classes from `Xabbuh\XApi\Storage\Api` to
  `XApi\Repository\Api`

0.1.2
-----

Do not allow to pull in packages that could potentially break backwards
compatibility.

0.1.1
-----

Moved `php-xapi/test-fixtures` package to the `require` section as the package
is required by other packages that make use of the base test class.

0.1.0
-----

First release defining a common interface for LRS repository backends.

This package replaces the `xabbuh/xapi-storage-api` package which is now
deprecated and should no longer be used.
