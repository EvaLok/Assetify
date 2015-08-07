<?php

namespace Assetify\v1;

use
	SplFileInfo,

	Assetify\v1\Minifier\Exception,

	Assetic\Factory\AssetFactory,
	Assetic\Factory\Worker\CacheBustingWorker,
	Assetic\FilterManager,
	Assetic\Filter\FilterInterface,
	Assetic\AssetWriter
;

class Minifier {
	private
		$files = []
		, $asset
		, $assetWebPath
		, $type
		, $filter
		, $minify
	;

	/**
	 * Expected Params:
	 * @param $params
	 * @throws $ex Assetify\v1\Minifier\Exception
	 */
	public function __construct( Array $params )
	{
		$this->asset = new SplFileInfo($params['asset']);
		$this->files = $params['files'];
		$this
			->setFilter($params['filter'])
			->setAssetWebPath($params['asset_web_path'])
		;
		$this->minify = (
			isset($params['minify']) && ! $params['minify']
				?
					false
				:
					true
		);
		switch( $type = $params['type'] ){
			case 'js':
			case 'css':
				$this->type = $type;
				break;

			default:
				throw new Exception("unknown type [$type]");
		}

		return $this;
	}

	public function output()
	{
		if( ! $this->minify ){
			return $this->getVerbose();
		}

		return $this->getMinified();
	}

	public function getVerbose()
	{
		$r = '';

		switch( $this->type ) {
			case 'js':
				foreach( $this->files as $file ){
					$r .= (
						'<script type="text/javascript" src="'
							. $file . '"></script>'
					);
				}
				break;

			case 'css':
				$r .= '<style type="text/css">' . "\n";
				foreach( $this->files as $file ){
					$r .= '@import url("' . $file . '");' . "\n";
				}
				$r .= '</style>';
				break;
		}

		return $r;
	}

	public function getMinified()
	{
		$r = '';

		if( ! (new SplFileInfo($this->asset->getPath()))->isWritable() ){
			throw new Exception(
				"path " . $this->asset->getPath() . " is not writable"
			);
		}

		$factory = new AssetFactory($this->asset->getPath());
		$factory->addWorker(new CacheBustingWorker());
		$factory->setDefaultOutput('*');

		$fm = new FilterManager();
		$fm->set('min', $this->filter);
		$factory->setFilterManager($fm);

		$asset = $factory->createAsset(
			$this->files,
			['min'],
			['name' => $this->asset->getBasename()]
		);

		// only write the asset file if it does not already exist..
		if( ! file_exists(
			$this->asset->getPath() . DIRECTORY_SEPARATOR
				. $asset->getTargetPath()
		)){
			$writer = new AssetWriter($this->asset->getPath());
			$writer->writeAsset($asset);

			// TODO: write some code to garbage collect files of a certain age?
			// possible alternative, modify CacheBustingWorker to have option
			// to append a timestamp instead of a hash
		}

		switch( $this->type ){
			case 'js':
				$r .= (
					'<script type="text/javascript" src="'
						. $this->assetWebPath
						. $asset->getTargetPath() . '"></script>'
				);
				break;

			case 'css':
				$r .= (
					'<link rel="stylesheet" type="text/css" href="'
						. $this->assetWebPath
						. $asset->getTargetPath() . '" />'
				);
		}

		return $r;
	}

	public function setFilter( FilterInterface $filter )
	{
		$this->filter = $filter;

		return $this;
	}

	public function setAssetWebPath( $path )
	{
		$path = trim($path, '/');
		$this->assetWebPath = str_pad(
			$path,
			strlen($path) + 1,
			'/',
			STR_PAD_RIGHT
		);

		return $this;
	}
}
