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
		$this->addFile(WWW_DIR . "/css/layout.less");
		$this->addFile(WWW_DIR . "/css/menu.less");
		$this->addFile(WWW_DIR . "/css/content.less");
		$this->addFile(WWW_DIR . "/css/text.less");
		$this->addFile(WWW_DIR . "/css/sidebar.less");
	}

}
