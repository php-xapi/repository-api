CHANGELOG
=========

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
