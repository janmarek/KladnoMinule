<?php

namespace KladnoMinule\Import;

use KladnoMinule\Model\Category\Category;

require_once __DIR__ . '/IImport.php';

class Categories extends AbstractImport
{
	public function clear(\Doctrine\ORM\EntityManager $em)
	{
		$em->createQuery('delete KladnoMinule\Model\Category\Category c')->execute();
		echo "Categories deleted.\n";
	}



	public function init(\Doctrine\ORM\EntityManager $em)
	{
		echo "Started creating categories.\n";

		$category = new Category(array(
			'name' => 'Fotografie',
		));
		$this->persist($em, $category, 1);

		$category2 = new Category(array(
			'name' => 'Pohlednice',
		));
		$this->persist($em, $category2, 2);

		$category3 = new Category(array(
			'name' => 'Příběhy',
		));
		$this->persist($em, $category3, 3);

		$category4 = new Category(array(
			'name' => 'Blog',
		));
		$this->persist($em, $category4, 4);

		$em->flush();

		echo "Categories created.\n";
	}



	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em)
	{

	}

}