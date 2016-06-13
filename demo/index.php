<?php

require(__DIR__ . '/../vendor/autoload.php');


use
	Assetify\v1\Minifier,
	Assetify\v1\Collection,

	Assetic\Filter\UglifyCssFilter,
	Assetic\Filter\UglifyJs2Filter
;

// get instance of asset collection
$ac = Collection::getInstance();

// set filter
$ac->addFilter('css', new UglifyCssFilter(
	'/usr/local/bin/uglifycss',
	'/usr/local/bin/node'
));
$ac->addFilter('js', new UglifyJs2Filter(
	'/usr/local/bin/uglifyjs',
	'/usr/local/bin/node'
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
	$ac->addAsset($asset, __DIR__ . '/' . $asset);
}

$deferredJs = [
	'js/deferred1.js',
	'js/deferred2.js',
];

foreach( $deferredJs as $js ){
	$ac->addAsset($js, __DIR__ . '/' . $js, 'deferred-js');
}

$notDeferredJs = [
	'js/deferred3.js',
	'js/deferred4.js',
];

foreach( $notDeferredJs as $js ){
	$ac->addAsset($js, __DIR__ . '/' . $js, 'not-minified-deferred-js');
}

?>

<html>
	<head>
		<title>
			assetify demo
		</title>

		<?php
			echo PHP_EOL . PHP_EOL;

			// output css asset
			echo $ac->getGroupAsset(
				'css',
				__DIR__ . '/assets/minified-css',
				'/assets/',
				'css'
			);

			echo PHP_EOL;

			// output js asset
			echo $ac->getGroupAsset(
				'js',
				__DIR__ . '/assets/minified-js',
				'/assets/',
				'js'
			);

			echo PHP_EOL;

			echo $ac->getGroupAssetDeferred(
				'deferred-js',
				__DIR__ . '/assets/deferred-minified-js',
				'/assets/',
				'js'
			);

			echo PHP_EOL;

			echo $ac->getGroupAssetDeferred(
				'not-minified-deferred-js',
				__DIR__ . '/assets/deferred-not-minified-js',
				'/assets/',
				'js',
				false
			);

			echo PHP_EOL . PHP_EOL;
		?>
	</head>
	<body>
		<div>
			<span>
				this is a test; feel free to check out the console or the source!
			</span>
		</div>
	</body>
</html>


