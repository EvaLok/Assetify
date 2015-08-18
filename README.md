[![Build Status](https://travis-ci.org/EvaLok/php-assetify.svg?branch=master)](https://travis-ci.org/EvaLok/php-assetify)

# Assetify
extremely simple to use wrapper for basic Assetic usage

provides an easy solution for asset consolidation / minification

if possible, i recommend using `mod_pagespeed` instead, but if you are for example running on a cPanel host using https, this might be a good minification solution for you.

# install
## component
`composer require evalok/php-assetify`

## development
`composer update`

## filter dependencies
install Assetic filter dependencies are may be necessary; if you're unsure of how to do this, you can simply use the demo filters listed below

## demo filters
- `sudo npm install -g uglifycss`
- `sudo npm install -g uglify-js`

## demo dependencies
- (from project root) `cd demo && bower install`

# example usage
https://github.com/EvaLok/php-assetify/blob/master/demo/index.php

# tests
- (from project)`vendor/bin/phpspec run`

# TODO
- @todo: more tests
- @todo: garbage collection
 
