<?php

use Nette\Environment, Nette\Debug, Nette\Web\Html;

require LIBS_DIR . '/Nette/loader.php';

if (defined('TEST_MODE')) {
	Environment::setName('test');
}

Debug::$strictMode = TRUE;
Debug::enable();
Html::$xhtml = false;

Environment::loadConfig();

// services
$serviceLoader = new Neuron\ServiceLoader;
$serviceLoader->loadNeonConfigFiles(Environment::getContext(), array(
	NEURON_DIR . "/Application/defaultServices.neon",
	APP_DIR . "/services.neon",
));

Neuron\Form\FormMacros::register();

// run
if (!Environment::isConsole()) {
	// error presenter
	$application = Environment::getApplication();
	$application->errorPresenter = 'Error';
	//$application->catchExceptions = TRUE;

	$router = $application->getRouter();

	$router[] = new Neuron\Application\SeoRouter("Front:Page", "default", "", function () {
		return Environment::getService("PageService")->getUrlDictionary();
	});

	$router[] = new Neuron\Application\SeoRouter("Front:Tag", "default", "tag/", function () {
		return Environment::getService("TagService")->getUrlDictionary();
	});

	$router[] = new Nette\Application\Route("<presenter>/<action>/<id>", array(
		"presenter" => "Front:Homepage",
		"action" => "default",
		"id" => null,
	));

	$application->run();
}
