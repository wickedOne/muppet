# muppet
unit testing your getters, setters, adders, removers, issers and whatevers.

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