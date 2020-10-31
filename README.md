# Sortable Tasks

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A simple, un-opinionated abstraction library to allow for the ordering of tasks.  Features:

* Useful for libraries like setup algorithms, middleware layer ordering, and other libraries where the ordering of tasks
  is determined in an arbitrary order, but need to be run in a deterministic one
* Builds on the [`marcj/topsort` library](https://packagist.org/packages/marcj/topsort) to enable sorting of tasks, each defined in their own class
* Un-opinionated about how tasks actually run; just concerned with sorting them based on their dependency and running them in-order
* PSR-4 and PSR-12 compliant

## Structure

This library only contains two files:

| `SortableTask.php`          | Interface for a task; contains two methods to define dependencies, `depeondsOn` and `mustRunBefore` |
| `SortableTasksIterator.php` | Iterator class that does the sorting and other work; implements `Iterable` and `Countable`          |

## Install

Via Composer

``` bash
$ composer require caseyamcl/sortable-tasks
```

## Usage

TODO: This.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email me@caseymclaughlin.com instead of using the issue tracker.

## Credits

- [Casey McLaughlin][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/caseyamcl/sortable-tasks.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/caseyamcl/sortable-tasks/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/caseyamcl/sortable-tasks.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/caseyamcl/sortable-tasks.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/caseyamcl/sortable-tasks.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/caseyamcl/sortable-tasks
[link-travis]: https://travis-ci.org/caseyamcl/sortable-tasks
[link-scrutinizer]: https://scrutinizer-ci.com/g/caseyamcl/sortable-tasks/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/caseyamcl/sortable-tasks
[link-downloads]: https://packagist.org/packages/caseyamcl/sortable-tasks
[link-author]: https://github.com/caseyamcl
[link-contributors]: ../../contributors
