# muppet
unit testing your getters, setters, adders, removers, issers and whatevers.

[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FwickedOne%2Fmuppet%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/wickedOne/muppet/master)
[![codecov](https://codecov.io/gh/wickedOne/muppet/branch/master/graph/badge.svg)](https://codecov.io/gh/solrphp/solarium-bundle)
[![PHPStan static analysis](https://github.com/wickedOne/muppet/actions/workflows/phpstan.yml/badge.svg)](https://github.com/solrphp/solarium-bundle/actions/workflows/phpstan.yml)
[![coding standards](https://github.com/wickedOne/muppet/actions/workflows/coding-standards.yml/badge.svg)](https://github.com/solrphp/solarium-bundle/actions/workflows/coding-standards.yml)

## installation
to add this library to your dev dependencies use
```bash
composer require --dev wickedone/muppet
```

## but why?
a lot has been written about the necessity of testing your getters and setters or why it shouldn't been done.
from my personal perspective, testing getters and setters provide a stable level of coverage
and thus the ability to pin your ci to a minimum coverage value.

## what it does
this library doesn't promise to generate perfect, non failing tests out of the box (though it tries).
it does however generate test classes which are easy to modify and, most importantly, are compatible with [infection](https://infection.github.io/guide/) (i.e. not too much black magic fuckery).

## usage
```php
$config = new Config([
  'base_dir' => '~/Code/Project/src',
  'test_dir' => '~/Code/Project/tests/Unit',
  'fragments' => [
      'Awesome',
      'Namespace',
      'Tests',
      'Unit',
    ],
]);

(new Generator($config))
  ->generate('MyEntity')
;
```

## assumptions
because we love those...

- iterable properties use adders and removers rather than setters
- ``Tests`` is part of the tests namespace

## symfony integration
please see the [muppet-bundle](https://github.com/wickedOne/muppet-bundle)