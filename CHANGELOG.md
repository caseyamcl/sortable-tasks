# Changelog

All notable changes to `sortable-tasks` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

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

## v0.1.1 - 2020-10-31
### Fixed
- Updated access from `private` to `protected` for `SortableTasksIterator::tasks` property to make extension via 
  inheritance easier 

## v0.1 - 2020-10-31 🎃
### Added
- Everything; initial release
