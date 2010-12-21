<?php

namespace KladnoMinule\Webloader;

/**
 * Front js
 *
 * @author Jan Marek
 */
class FrontJs extends \Neuron\Webloader\DefaultFrontJs
{
	protected function init()
	{
		parent::init();
		$this->addFiles(array(
			// texyla

			// core
			"texyla/js/texyla.js",
			"texyla/js/selection.js",
			"texyla/js/texy.js",
			"texyla/js/buttons.js",
			"texyla/js/dom.js",
			"texyla/js/view.js",
			//"texyla/js/ajaxupload.js",

			// languages
			"texyla/languages/cs.js",
			//"texyla/languages/sk.js",
			//"texyla/languages/en.js",

			// plugins
			"texyla/plugins/keys/keys.js",
			"texyla/plugins/window/window.js",
			"texyla/plugins/resizableTextarea/resizableTextarea.js",
			"texyla/plugins/img/img.js",
			"texyla/plugins/link/link.js",
			//"texyla/plugins/emoticon/emoticon.js",
			"texyla/plugins/symbol/symbol.js",

			WWW_DIR . "/js/web.js",
		));
	}
}