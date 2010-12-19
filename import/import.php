<?php

namespace KladnoMinule\Import;

require __DIR__ . '/../index.php';
require __DIR__ . '/dibi.min.php';

$em = \Nette\Environment::getService('Doctrine\ORM\EntityManager');

// original db
$dibi = new \DibiConnection(array(
	'driver' => 'mysql',
	'host' => '127.0.0.1',
	'username' => 'root',
	'password' => '',
	'database' => 'kladnominule',
));

require __DIR__ . '/Users.php';
require __DIR__ . '/Languages.php';
require __DIR__ . '/Categories.php';
require __DIR__ . '/Pages.php';

$imports[] = new Users;
$imports[] = $categoriesImport = new Categories;
$pagesImport = new Pages($categoriesImport);
$pagesImport->fromParents = array(2, 3, 4);
$pagesImport->fromLanguages = array('cs');
$imports[] = $pagesImport;

foreach (array_reverse($imports) as $import) {
	$import->clear($em);
}

foreach ($imports as $import) {
	$import->init($em);
	$import->import($dibi, $em);
}

