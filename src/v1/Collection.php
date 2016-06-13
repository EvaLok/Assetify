<?php

namespace Assetify\v1;

use
	SplFileInfo,

	Assetify\v1\Collection\Exception,
	Assetify\v1\Minifier,

	Assetic\Filter\FilterInterface
;

class Collection {
	private static $instance;

	private
		$groups = []
		, $filters = []
	;

	public function addAsset( $path_web, $path_fs, $group = null )
	{
		$fi = new SplFileInfo($path_fs);

		// if group not set, use extension as group
		if( ! isset($group) ){
			$group = strtolower($fi->getExtension());
		}

		$this->groups[$group][] = [
			'web'=> $path_web,
			'fs' => $path_fs
		];
	}

	public function addFilter( $type, FilterInterface $filter )
	{
		$this->filters[$type] = $filter;
	}

	public function getFilter($type)
	{
		return $this->filters[$type];
	}

	public function getGroup( $group )
	{
		if( ! isset($this->groups[$group]) ){
			throw new Exception("unknown group [$group]");
		}

		return $this->groups[$group];
	}

	public function getGroupAsset(
		$group,
		$asset,
		$assetWebPath,
		$type = null,
		$minify = true
	){
		if( ! isset($this->filters[$type]) ){
			throw new Exception("no filter set for type [$type]");
		}

		return (
			new Minifier([
				'asset' => $asset,
				'asset_web_path' => $assetWebPath,
				'files' => self::getGroup($group),
				'type' => $type ?: $group,
				'filter' => self::getFilter($type),
				'minify' => $minify
			])
		)->output();
	}

	public function getGroupAssetDeferred(
		$group,
		$asset,
		$assetWebPath,
		$type = null,
		$minify = true
	){
		if( ! isset($this->filters[$type]) ){
			throw new Exception("no filter set for type [$type]");
		}

		return (
			new Minifier([
				'asset' => $asset,
				'asset_web_path' => $assetWebPath,
				'files' => self::getGroup($group),
				'type' => $type ?: $group,
				'filter' => self::getFilter($type),
				'minify' => $minify,
				'defer' => true
			])
		)->output();
	}

	static public function getInstance()
	{
		return static::$instance = (
			! is_null(static::$instance)
				?
					static::$instance
				:
					new static
		);
	}
}
