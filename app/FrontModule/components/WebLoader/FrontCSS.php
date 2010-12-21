<?php

namespace KladnoMinule\WebLoader;

/**
 * FrontCSS
 *
 * @author Jan Marek
 */
class FrontCSS extends \Neuron\Webloader\DefaultFrontCss
{
	protected function init()
	{
		parent::init();
		$this->addFiles(array(
			WWW_DIR . "/css/layout.less",
			WWW_DIR . "/css/menu.less",
			WWW_DIR . "/css/content.less",
			WWW_DIR . "/css/text.less",
			WWW_DIR . "/css/sidebar.less",
			WWW_DIR . "/js/texyla/css/style.css",
		));
	}

}
