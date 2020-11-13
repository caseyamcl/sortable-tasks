<?php

/**
 * Sortable Tasks Library
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/caseyamcl/sortable-tasks
 * @version 1
 * @package caseyamcl/sortable-tasks
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * ------------------------------------------------------------------
 */

declare(strict_types=1);

namespace SortableTasks;

use PHPUnit\Framework\TestCase;

class TwoWaySorterTest extends TestCase
{
    public function testInstantiate(): void
    {
        $sorter = new TwoWaySorter();
        $this->assertInstanceOf(TwoWaySorter::class, $sorter);
    }

    public function testBasicDependencies(): void
    {
        $sorter = new TwoWaySorter();
        $sorter->add('a', ['b', 'c']);
        $sorter->add('b', ['c']);
        $sorter->add('c');
        $this->assertSame(['c', 'b', 'a'], $sorter->sort()->getArrayCopy());
    }

    public function testTwoWayDependency(): void
    {
        $sorter = new TwoWaySorter();
        $sorter->add('a', ['b', 'c', 'd'], ['e']);
        $sorter->add('b', ['c'], ['d']);
        $sorter->add('c');
        $sorter->add('d');
        $sorter->add('e');

        $this->assertSame(['c', 'b', 'd', 'a', 'e'], $sorter->sort()->getArrayCopy());
    }

    public function testCountWhenItemsPresent(): void
    {
        $sorter = new TwoWaySorter();
        $sorter->add('a', ['b']);
        $sorter->add('b');
        $this->assertSame(2, $sorter->count());
    }

    public function testCountWhenEmpty(): void
    {
        $sorter = new TwoWaySorter();
        $this->assertSame(0, $sorter->count());
    }

    public function testContainsReturnsTrueForExistentValue(): void
    {
        $sorter = new TwoWaySorter();
        $sorter->add('a');
        $this->assertTrue($sorter->contains('a'));
    }

    public function testContainsReturnsFalseForNonExistentValue(): void
    {
        $sorter = new TwoWaySorter();
        $sorter->add('a');
        $this->assertFalse($sorter->contains('b'));
    }

    public function testMustRunFirst(): void
    {
        $sorter = new TwoWaySorter();
        $sorter->add('a', ['b', 'c', 'd'], ['e']);
        $sorter->add('b', ['c'], ['d']);
        $sorter->add('c');
        $sorter->add('d');
        $sorter->add('e');
        $sorter->add('f', ['d']);
        $result = $sorter->sort('f');
        $this->assertEquals(['f','c','b','d','a','e'], $result->getArrayCopy());
    }
}
