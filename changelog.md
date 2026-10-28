# Changelog

All notable changes to `Notes` will be documented in this file.

## 3.0.0

- Extract task management into `ilbronza/tasks:^1.0`; applications using tasks must
  add that dependency when updating Notes.
- Preserve old task class names and menu entry points as compatibility adapters.
- Introduce the generic `AuthorizesNotes` subject-permission contract.
- Notes boots and migrates without the Tasks package.
- Preserve existing migration identifiers and note data during the extraction.

## Version 1.0

### Added
- Everything
