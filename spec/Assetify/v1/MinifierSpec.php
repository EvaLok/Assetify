<?php

namespace spec\Assetify\v1;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Assetic\Filter\UglifyCssFilter;

class MinifierSpec extends ObjectBehavior
{
	function it_should_instantiate_with_proper_params( UglifyCssFilter $filter )
	{
		$this->instantiate()->shouldHaveType('Assetify\v1\Minifier');
	}

	public function instantiate( $minify = true )
	{
		$filter = new UglifyCssFilter(
			'/usr/local/bin/uglifycss'
		);

		$this->beConstructedWith([
			'asset' => 'fs/path/to/test-asset',
			'asset_web_path' => 'web/path/to/test-asset',
			'files' => [
				'path/to/file1.css',
				'path/to/file2.css'
			],
			'type' => 'css',
			'filter' => $filter,
			'minify' => $minify
		]);

		return $this;
	}
}
