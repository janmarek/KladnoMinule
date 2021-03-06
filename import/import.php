<?php

namespace KladnoMinule\Import;

require __DIR__ . '/../index.php';
require __DIR__ . '/dibi.min.php';

// new db entity manager
$em = \Nette\Environment::getService('Doctrine\ORM\EntityManager');

// original db
$dibi = new \DibiConnection(array(
	'driver' => 'mysql',
	'host' => '127.0.0.1',
	'username' => 'root',
	'password' => '',
	'database' => 'kladnoweb',
));

// define imports
require __DIR__ . '/Users.php';
$usersImport = new Users;

require __DIR__ . '/Categories.php';
$categoriesImport = new Categories;

require __DIR__ . '/Pages.php';
$pagesImport = new Pages($categoriesImport, $usersImport);

require __DIR__ . '/Comments.php';
$commentsImport = new Comments($usersImport, $pagesImport);

require __DIR__ . '/Photos.php';
$photosImport = new Photos($pagesImport);

$imports = array(
	$usersImport,
	$categoriesImport,
	$pagesImport,
	$commentsImport,
	$photosImport,
);

// clear db
foreach (array_reverse($imports) as $import) {
	$import->clear($em);
}

// import data
foreach ($imports as $import) {
	$import->init($em);
	$import->import($dibi, $em);
}

