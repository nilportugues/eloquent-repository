# Eloquent Repository

Eloquent Repository using *[nilportugues/repository](https://github.com/nilportugues/php-repository)* as foundation.

## Installation

Use [Composer](https://getcomposer.org) to install the package:

```json
$ composer require nilportugues/eloquent-repository
```

## Why bother?

Using this implementation you can switch it out to test your code without setting up databases.

**Drivers:**

- `composer require nilportugues/repository` for an InMemoryRepository implementation.
- `composer require nilportugues/filesystem-repository` for a FileSystemRepository.
- `composer require nilportugues/doctrine-repository` for an Doctrine implementation if you change or mind.

Doesn't sound handy? Let's think of yet another use case you'll love using this. `Functional tests` and `Unitary test`.

No database connection will be needed, nor fakes. Using an `InMemoryRepository` or `FileSystemRepository` implementation will make those a breeze to code. And once the tests finish, all data may be destroy with not worries at all.
