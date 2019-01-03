# php-loremipsum

[![Build Status](https://travis-ci.org/joshtronic/php-loremipsum.svg?branch=master)](https://travis-ci.org/joshtronic/php-loremipsum)
[![Coverage Status](https://coveralls.io/repos/github/joshtronic/php-loremipsum/badge.svg?branch=master)](https://coveralls.io/github/joshtronic/php-loremipsum?branch=master)
[![Total Downloads](https://poser.pugx.org/joshtronic/php-loremipsum/downloads)](https://packagist.org/packages/joshtronic/php-loremipsum)

Lorem ipsum generator in PHP without dependencies. Compatible with PHP 5.3+.

[![Become a Patron](https://joshtronic.com/images/become-patron.png)](https://www.patreon.com/joshtronic)

## Installation

The preferred installation method is via `composer`. First add the following to
your `composer.json`:

```json
"require": {
    "joshtronic/php-loremipsum": "dev-master"
}
```

Then run `composer update`.

## Usage

### Getting Started

```php
$lipsum = new joshtronic\LoremIpsum();
```

### Generating Words

```php
echo '1 word: '  . $lipsum->word();
echo '5 words: ' . $lipsum->words(5);
```

### Generating Sentences

```php
echo '1 sentence: '  . $lipsum->sentence();
echo '5 sentences: ' . $lipsum->sentences(5);
```

### Generating Paragraphs

```php
echo '1 paragraph: '  . $lipsum->paragraph();
echo '5 paragraphs: ' . $lipsum->paragraphs(5);
```

### Wrapping Text with HTML Tags

If you would like to wrap the generated text with a tag, pass it as the second
parameter:

```php
echo $lipsum->paragraphs(3, 'p');

// Generates: <p>Lorem ipsum...</p><p>...</p><p>...</p>
```

Multiple tags can also be specified:

```php
echo $lipsum->sentences(3, ['article', 'p']);

// Generates: <article><p>...</p></article><article><p>...</p></article><article><p>...</p></article>
```

And you can back reference using `$1`:

```php
echo $lipsum->words(3, '<li><a href="$1">$1</a></li>');

// Generates: <li><a href="...">...</a></li><li><a href="...">...</a></li><li><a href="...">...</a></li>
```

### Return as an Array

Perhaps you want an array instead of a string:

```php
print_r($lipsum->wordsArray(5));
print_r($lipsum->sentencesArray(5));
print_r($lipsum->paragraphsArray(5));
```

You can still wrap with markup when returning an array:

```php
print_r($lipsum->wordsArray(5, 'li'));
```

## Assumptions

The first string generated will always start with the traditional "Lorem ipsum
dolor sit amet, consectetur adipiscing elit". Subsequent strings may contain
those words but will not explicitly start with them.

## Contributing

Suggestions and bug reports are always welcome, but karma points are earned for
pull requests.

Unit tests are required for all contributions. You can run the test suite from
the `tests` directory simply by running `phpunit .`

## Credits

`php-loremipsum` was originally inspired by
[badcow/lorem-ipsum](https://packagist.org/packages/badcow/lorem-ipsum) with a
goal of being a dependency free lorem ipsum generator with flexible generation
options.

## License

MIT
