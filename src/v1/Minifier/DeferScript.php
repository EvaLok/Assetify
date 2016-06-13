<?php

namespace Assetify\v1\Minifier;

class DeferScript {
	private $output;

	const executor = '
		if (window.addEventListener)
			window.addEventListener("load", downloadJSAtOnload, false);
			else if (window.attachEvent)
			window.attachEvent("onload", downloadJSAtOnload);
			else window.onload = downloadJSAtOnload;
	';

	public function __construct( $files = [] )
	{
		$output = '<script type="text/javascript">';
		$output .= '(function(){'; // create isolated scope

		$output .= static::executor;
		$output .= $this->createLoaderFunction($files);

		$output .= '})();';
		$output .= '</script>';

		$this->output = $output;
		return $this;
	}

	private function createLoaderFunction( $files = [] )
	{
		$output = 'function downloadJSAtOnload() {';

		foreach( $files as $idx => $file ){
			$output .= (
				'var element' . $idx . ' = document.createElement("script");'
				. 'element' . $idx . '.src = "' . $file['web'] . '";'
				. 'document.body.appendChild(element' . $idx . ');'
			);
		}

		$output .= '}';

		return $output;
	}

	public function __toString(){
		return $this->output;
	}
}
