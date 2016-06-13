[![Build Status](https://travis-ci.org/EvaLok/php-assetify.svg?branch=master)](https://travis-ci.org/EvaLok/php-assetify)

# Assetify
extremely simple to use wrapper for basic Assetic usage

provides an easy solution for asset consolidation / minification and js deferral

you may want to consider using this in conjunction with `ModPagespeed`, in particular its css deferring functionality is pretty nice

# install
## component
`composer require evalok/php-assetify`

## filter dependencies
install Assetic filter dependencies are may be necessary; if you're unsure of how to do this, you can simply use the demo filters listed below

## demo filters
- `sudo npm install -g uglifycss`
- `sudo npm install -g uglify-js`

## demo dependencies
- (from project root) `cd demo && bower install`

# example usage
## working example
https://github.com/EvaLok/php-assetify/blob/master/demo/index.php

## minify css
```php
echo $ac->getGroupAsset(
	'css',
	__DIR__ . '/assets/minified-css',
	'/assets/',
	'css'
);
```

## minify js
```php
echo $ac->getGroupAsset(
	'js',
	__DIR__ . '/assets/minified-js',
	'/assets/',
	'js'
);
```

## minify and defer js
```php
echo $ac->getGroupAssetDeferred(
	'deferred-js',
	__DIR__ . '/assets/deferred-minified-js',
	'/assets/',
	'js'
);
```


# tests
- (from project)`vendor/bin/phpspec run`

# TODO
- @todo: more tests
- @todo: garbage collection
 
