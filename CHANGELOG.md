# Changelog

All notable changes to `sortable-tasks` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## v0.6.1 - 2021-03-02
### Added
- Support for `marcj/topsort` version 2.0 (which works on PHP 8)

## v0.6 - 2020-11-06
### Added
- New `TwoWaySorter.php` class for sorting strings that have dependencies and constraints

### Changed
- Refactored `SortableTasksIterator` to use `TwoWaySorter.php`

## v0.5 - 2020-11-05
### Added
- `SortableTaskIterator::contains()` method

## v0.4 - 2020-11-05
### Fixed
- Iterator no longer generates error when it is empty

## v0.3 - 2020-11-05
### Removed
- Removed return typehint from `SortableTasksIterator.php` so it can be used more flexibly

## v0.2 - 2020-11-02
### Added
- Ability to add multiple tasks via `SortableTaskIterator::add()` method
- GitHub Action runner config 
 
### Changed
- Refactored `build()` syntax around new `add` method
- Removed some extraneous comments and added some where they are actually useful 
- Fixed coding standard `phpcs.xml.dist` (should be PSR12) 
 
### Removed
- Support for PHP versions < 7.4
- Removed `void` return restriction from `SortableTaskIterator::add()` method
- TravisCI runner config

### Fixed
- Updated access from `private` to `protected` for `SortableTasksIterator::tasks` property to make extension via 
  inheritance easier 

## v0.1 - 2020-10-31 🎃
### Added
- Everything; initial release
