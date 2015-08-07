<?php

require(__DIR__ . '/../vendor/autoload.php');


use
	Assetify\v1\Minifier,
	Assetify\v1\Collection,

	Assetic\Filter\UglifyCssFilter,
	Assetic\Filter\UglifyJs2Filter
;

// set filter
Collection::addFilter('css', new UglifyCssFilter(
	'/usr/local/bin/uglifycss'
));
Collection::addFilter('js', new UglifyJs2Filter(
	'/usr/local/bin/uglifyjs'
));

$assets = [
	// css
	'css/style1.css',
	'css/style2.css',
	'css/style3.css',

	// js
	'bower_components/jquery/dist/jquery.js',
	'js/demo.js',
];

foreach( $assets as $asset ){
	Collection::addAsset($asset, __DIR__ . '/' . $asset);
}

?>

<html>
	<head>
		<title>
			assetify demo
		</title>

		<?php
			// output css asset
			echo Collection::getGroupAsset(
				'css',
				__DIR__ . '/assets/minified-css',
				'/assets/',
				'css'
				// add false param for verbose (non-minified, non-consolidated)
//				, false
			);

			// output js asset
			echo Collection::getGroupAsset(
				'js',
				__DIR__ . '/assets/minified-js',
				'/assets/',
				'js'
				// add false param for verbose (non-minified, non-consolidated)
//				, false
			);
		?>
	</head>
	<body>
		<div>
			<span>
				this is a test
			</span>
		</div>
	</body>
</html>


