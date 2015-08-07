<?php

require(__DIR__ . '/../vendor/autoload.php');


use
	Assetify\v1\Minifier,
	Assetify\v1\Collection,

	Assetic\Filter\UglifyCssFilter
;

// set filter
Collection::addFilter('css', new UglifyCssFilter(
	'/usr/local/lib/node_modules/uglifycss/uglifycss'
));

$css = [
	'css/style1.css',
	'css/style2.css',
	'css/style3.css',
];

foreach( $css as $asset ){
	Collection::addAsset(__DIR__ . '/' . $asset);
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
				__DIR__ . '/assets/minified.css',
				'/assets/',
				'css'
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


