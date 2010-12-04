<?php

use Nette\Environment, Nette\Debug, Nette\Web\Html;

require LIBS_DIR . '/Nette/loader.php';

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

// error presenter
$application = Environment::getApplication();
$application->errorPresenter = 'Error';
//$application->catchExceptions = TRUE;

$router = $application->getRouter();

$router[] = new Nette\Application\Route("<presenter>/<action>/<id>", array(
	"presenter" => "Front:Homepage",
	"action" => "default",
	"id" => null,
));

Neuron\Form\FormMacros::register();

// run
if (!Environment::isConsole()) {
	$application->run();
}
