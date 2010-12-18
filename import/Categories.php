<?php

namespace KladnoMinule\Import;

use KladnoMinule\Model\Category\Category;

require_once __DIR__ . '/IImport.php';

class Categories implements IImport
{
	private $map;



	public function clear(\Doctrine\ORM\EntityManager $em)
	{
		$em->createQuery('delete KladnoMinule\Model\Category\Category c')->execute();
		echo "Categories deleted.\n";
	}



	public function getImportedMap()
	{
		return $this->map;
	}



	public function init(\Doctrine\ORM\EntityManager $em)
	{
		echo "Started creating categories.\n";

		$this->map["2"] = $category2 = new Category(array(
			'name' => 'Fotografie',
		));

		$this->map["3"] = $category3 = new Category(array(
			'name' => 'Pohlednice',
		));

		$this->map["4"] = $category4 = new Category(array(
			'name' => 'Příběhy',
		));

		$em->persist($category2);
		$em->persist($category3);
		$em->persist($category4);
		$em->flush();

		echo "Categories created.\n";
	}



	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em)
	{

	}

}