# Sortable Tasks

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
![Build](https://github.com/caseyamcl/sortable-tasks/workflows/Build/badge.svg)
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A simple, un-opinionated PHP 7.4+ abstraction library to allow for the ordering of tasks.  Features:

* Tasks are service class instances that can define other tasks as dependencies
* Useful for libraries like setup routines, ensuring that HTTP middleware runs in-order, and other libraries where the ordering of tasks
  is determined in an arbitrary order, but need to be run deterministically
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

> Refer to the `tests/Fixture` directory for a fully functional example.

The best way to demonstrate this library is with an example, so we'll use a setup application.  In our hypothetical
application, setup tasks can be registered in any order, but they will run in a particular order based on a set of
explicitly defined dependencies.

First, we must define a class that implements the `SortableTask` interface:

```php

use SortableTasks\SortableTask;

abstract class SetupStep implements SortableTask
{
    abstract public function __invoke(): bool;
}
 
``` 

Notice that we do not implement the `dependsOn()` and `mustRunBefore()` methods in the abstract `SetupStep` class. This
means that each concrete implementation step must define its dependencies. This is optional, and is up to the library
that implements SortableTasks.

If most steps do not require ordering, then we could do the following:

```php

use SortableTasks\SortableTask;

abstract class SetupStep implements SortableTask
{
    abstract public function __invoke(): bool;

    // Provide default implementations of `dependsOn` and `mustRunBefore` that return empty arrays
    public static function dependsOn() : iterable
    {
        return [];
    }
    public static function mustRunBefore() : iterable
    {
        return [];
    }
}
```

Let's create some setup steps now:

```php

class CheckConfigStep extends SetupStep
{
    public static function dependsOn(): iterable
    {
       return []; // depends on nothing; can run anytime in the order of operations
    }
    
    public function __invoke(): bool
    {
        // do stuff, then..
        return true;
    }
}

class CheckDbConnectionStep extends SetupStep
{
    private DbConnector $dbConnector;
    
    public function __construct(DbConnector $dbConnector)
    {    
        $this->dbConnector = $dbConnector;
    }

    public static function dependsOn(): iterable
    {
        return [CheckConfigStep::class];
    }

    public static function mustRunBefore(): iterable
    {
        return [BuildContainerStep::class];
    }

    public function __invoke(): bool
    {
        // do stuff, then..
        return $this->dbConnector->checkConnection();
    }
}

class BuildContainerStep extends SetupStep
{
    private ContainerBuilder $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    public static function dependsOn(): iterable
    {
        return [CheckConfigStep::class, CheckDbConnection::class];
    }

    public function __invoke(): bool
    {
        // do stuff, then..
        return $this->containerBuilder->buildContainer();
    }
}

```

Now that we have some concrete classes, let's add them to a SortableTasksIterator:

```php
use SortableTasks\SortableTasksIterator;

$iterator = new SortableTasksIterator();

// Notice that it doesn't matter in what order we add the steps; they will get sorted at runtime
$iterator->add(new BuildContainerStep());
$iterator->add(new CheckDbConnectionStep());
$iterator->add(new CheckConfigStep());

// Tasks are sorted upon calling the iterator
// Class names are the keys
foreach ($iterator as $setupStepClassName => $setupStep) {
    if (! $setupStep()->__invoke()) {
        throw new SetupFailedException('Setup failed on step: ' . $setupStepClassName);
    }
}
```

### Handling errors

There are two issues that are likely to occur during task execution, both of them throw excpetions:

1. Circular dependencies; e.g., Task "A" depends on Task "B", which depends on Task "A". In this situation, a 
   `MJS\TopSort\CircularDependecyException` is thrown.
2. Non-existent dependencies; e.g., Task "A" depends on Task "B", but task "B" is not defined. In this situation, a
   `MJS\TopSort\ElementNotFoundException` is thrown.

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
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/caseyamcl/sortable-tasks.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/caseyamcl/sortable-tasks.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/caseyamcl/sortable-tasks.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/caseyamcl/sortable-tasks
[link-scrutinizer]: https://scrutinizer-ci.com/g/caseyamcl/sortable-tasks/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/caseyamcl/sortable-tasks
[link-downloads]: https://packagist.org/packages/caseyamcl/sortable-tasks
[link-author]: https://github.com/caseyamcl
[link-contributors]: ../../contributors
