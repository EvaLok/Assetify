<?php

namespace Assetify\v1;

use
	SplFileInfo,

	Assetify\v1\Collection\Exception,
	Assetify\v1\Minifier,

	Assetic\Filter\FilterInterface
;

class Collection {
	static private
		$groups = []
		, $filters = []
	;

	private function __construct()
	{
		// singleton
	}

	static public function addAsset( $path, $group = null )
	{
		$fi = new SplFileInfo($path);

		// if group not set, use extension as group
		if( ! isset($group) ){
			$group = strtolower($fi->getExtension());
		}

		self::$groups[$group][] = $path;
	}

	static public function addFilter( $type, FilterInterface $filter )
	{
		self::$filters[$type] = $filter;
	}

	static public function getGroup( $group )
	{
		if( ! isset(self::$groups[$group]) ){
			throw new Exception("unknown group [$group]");
		}

		return self::$groups[$group];
	}

	static public function getGroupAsset(
		$group,
		$asset,
		$assetWebPath,
		$type = null,
		$minify = true
	){
		if( ! isset(self::$filters[$type]) ){
			throw new Exception("no filter set for type [$type]");
		}

		return (
			new Minifier([
				'asset' => $asset,
				'asset_web_path' => $assetWebPath,
				'files' => self::getGroup($group),
				'type' => $type ?: $group,
				'filter' => self::$filters[$type],
				'minify' => $minify
			])
		)->output();
	}
}
