# PHP script runner

Stores php scripts and runs them without the need to find the folders and files first.

## Configuration

The scripts are stored in `scripts.php` which looks like
```php
<?php

return [
    'tb' => [__DIR__ . '/../backuper', 'thunderbird.php', '', ''],
    'repos' => [__DIR__ . '/../repos2', 'artisan', 'xyz', 'abc:'],
];

```
- array key: defines name for the script.
- first array value: relative or absolute path to the folder where the script is located.
- second: script file name
- third: default argument - is inserted if none other is given
- fourth: default prefix for first argument - useful e. g. for laravel command namespaces

## Get started

- run `composer install` to install dependencies
- within the directory you can run `php run` to execute the script.
- you can define a global console alias `run="php /path/to/run"` to type `run` anywhere in the terminal - or any other alias you like
- when `php run` or `run` is called without arguments, a list of all registered scripts is displayed
- for calling a script, just append it:
    - `run tb`
    - `run tb --option`
    - `php run repos` -> default option `xyz` is appended => same as `php run repos xyz`
    - `php run repos test -a 5` -> `test` is prefixed with `abc:` => same as `php run repos abc:test -a 5`
