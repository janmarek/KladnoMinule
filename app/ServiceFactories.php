<?php

namespace KladnoMinule;

/**
 * ServiceFactories
 *
 * @author Jan Marek
 */
class ServiceFactories
{
	public static function createHelperLoader() {
		$loader = \Neuron\ServiceFactories::createHelperLoader();
		$loader->setHelper("pagethumbnail", "KladnoMinule\Helper\PageThumbnail::getImage");
		return $loader;
	}

}
