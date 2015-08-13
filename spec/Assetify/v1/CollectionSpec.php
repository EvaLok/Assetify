<?php

namespace spec\Assetify\v1;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Assetic\Filter\UglifyCssFilter;

class CollectionSpec extends ObjectBehavior
{
	function it_should_add_an_asset_to_a_specified_group()
	{
		$this->addAsset('/web/path/to/asset.js', '/fs/path/to/asset.js', 'g1');
		$this->getGroup('g1')->shouldContain([
			'web' => '/web/path/to/asset.js',
			'fs' => '/fs/path/to/asset.js'
		]);
	}

	function it_should_use_asset_extension_as_group_for_unspecified_group()
	{
		$this->addAsset('/web/path/to/asset.js', '/fs/path/to/asset.js');
		$this->getGroup('js')->shouldContain([
			'web' => '/web/path/to/asset.js',
			'fs' => '/fs/path/to/asset.js'
		]);
	}

	function it_should_add_filters_based_on_type_provided()
	{
		$filter = new UglifyCssFilter(
			'/usr/local/bin/uglifycss'
		);

		$this->addFilter('css', $filter);
		$this->getFilter('css')
			->shouldHaveType('Assetic\Filter\UglifyCssFilter')
		;
	}
}
