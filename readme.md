# Notes

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require ilbronza/notes
```

## Usage

### Task conversations

Run the package migrations with `php artisan migrate` after updating. The task
workspace is available at `/tasks-management` when tasks are enabled. It includes
list and board views; opening an activity shows its conversation first.

Team members can expand **Partecipanti** and enter the email of an existing client
account. That account can then open **Le mie attività**, read shared messages, and
reply with attachments. Removing a participant revokes access to the activity and
its conversation downloads. This action does not send an email invitation.

The composer distinguishes **Messaggio condiviso** from **Nota interna**. Existing
notes remain internal. Clients cannot read internal notes or attachments, change
task status, or access the advanced table. Task descriptions and tracking fields
remain visible to staff only. Shared message attachments use authenticated,
task-scoped download routes.

Staff roles default to `notes.defaultRoles`; applications may set
`notes.conversation.staffRoles` and the existing `notes.routeRoles` settings.
Keep client roles out of the staff roles. The `Task::userCanSee`, `userCanUpdate`,
and `userCanComment` methods can be overridden in the configured task model.
Conversation files use the `local` disk by default; a different private disk can
be set through `notes.conversation.disk`.

The migration changes polymorphic note keys to strings so UUID tasks can have
notes alongside models with integer keys. Rolling it back keeps string keys to
preserve those references.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email davide@sistema.srl instead of using the issue tracker.

## Credits

- [Davide Bronzini][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ilbronza/notes.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ilbronza/notes.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ilbronza/notes/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/ilbronza/notes
[link-downloads]: https://packagist.org/packages/ilbronza/notes
[link-travis]: https://travis-ci.org/ilbronza/notes
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/ilbronza
[link-contributors]: ../../contributors
