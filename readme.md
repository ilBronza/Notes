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

### Tasks moved to ilbronza/tasks

Notes 3 contains generic polymorphic notes, attachments and notifications. Task
management is now provided by [ilbronza/tasks](https://github.com/ilBronza/Tasks).
Applications using tasks must update both dependencies together:

```bash
composer require ilbronza/notes:^3.0 ilbronza/tasks:^1.0 --with-all-dependencies
php artisan optimize:clear
php artisan migrate
```

The Tasks package preserves existing task classes, published Notes configuration,
route names, URLs, menus and data. See its
[upgrade guide](https://github.com/ilBronza/Tasks/blob/main/UPGRADING.md).
Applications using only generic notes do not need Tasks.

Note subjects can implement `IlBronza\Notes\Contracts\AuthorizesNotes` to refine
view, update and delete permissions without Notes depending on their package.
Unknown subject classes deny access to their notes.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
python3 .ibtest/bin/ibtest.py Notes # from the parent packages workspace
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
