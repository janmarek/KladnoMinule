<?php

namespace KladnoMinule\Import;

use KladnoMinule\Model\Language\Language;

require_once __DIR__ . '/IImport.php';

class Languages implements IImport
{
	public function clear(\Doctrine\ORM\EntityManager $em)
	{
		$em->createQuery('delete KladnoMinule\Model\Language\Language l')->execute();
		echo "Languages deleted.\n";
	}



	public function init(\Doctrine\ORM\EntityManager $em)
	{
		echo "Started creating languages.\n";

		$em->persist(new Language(array(
			'name' => 'CZ',
			'url' => 'cs',
		)));
		$em->flush();

		echo "Languages created.\n";
	}



	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em)
	{

	}

}