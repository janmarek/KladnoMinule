<?php

namespace KladnoMinule\Import;

use KladnoMinule\Model\Page\Page;

require_once __DIR__ . '/IImport.php';

class Pages extends AbstractImport
{
	private $categoriesImport;

	private $usersImport;



	public function __construct($categoriesImport, $usersImport)
	{
		$this->categoriesImport = $categoriesImport;
		$this->usersImport = $usersImport;
	}



	public function clear(\Doctrine\ORM\EntityManager $em)
	{
		$em->createQuery('delete KladnoMinule\Model\Page\Page p')->execute();
		echo "Pages deleted.\n";
	}



	public function init(\Doctrine\ORM\EntityManager $em)
	{

	}



	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em)
	{
		echo "Started importing pages.\n";

		// select data

		$res = $dibi->select("*")->from("text")
			->where("parent in %in", array(2, 3, 4, 37, 78))
			->and("secret = 0")
			->execute();

		$res->setType('id', \dibi::INTEGER);
		$res->setType('author', \dibi::INTEGER);
		$res->setType('datetime_create', \dibi::DATETIME);

		$pages = $res->fetchAll();

		// import

		$urls = array();

		// imported categories
		$categoriesMap = $this->categoriesImport->getImportedMap();
		$parentToCategoryMapping = array(
			2 => 1, 3 => 2, 4 => 3, 37 => 4, 78 => 3,
		);

		// imported authors
		$authorMap = $this->usersImport->getImportedMap();

		foreach ($pages as $page) {
			// author is Roman Hájek and it is not blog
			// || author is Jan Marek
			// || author is not set
			if (($page->author == 2 && $page->parent != 37) || $page->author == 1 || !$page->author) {
				$author = null;
			} else {
				$author = $authorMap[$page->author];
			}

			// select category
			if (isset($parentToCategoryMapping[$page->parent])) {
				$category = $categoriesMap[$parentToCategoryMapping[$page->parent]];
			} else {
				$category = null;
			}

			// create unique url
			if (in_array($page->url, $urls)) {
				$url = $page->url . "-" . $category->getUrL();
			} else {
				$url = $page->url;
			}

			$urls[] = $url;

			$pageEntity = new Page(array(
				'name' => $page->name,
				'url' => $url,
				'created' => $page->datetime_create,
				'author' => $author,
				'allowed' => $page->allowed,
				'description' => $page->description,
				'text' => $page->text_texy,
				'category' => $category,
			));

			$this->persist($em, $pageEntity);

			echo "Page " . $pageEntity->getName() . " imported.\n";
		}

		$em->flush();
		echo "Pages imported.\n";
	}

}