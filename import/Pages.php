<?php

namespace KladnoMinule\Import;

use KladnoMinule\Model\Page\Page;

require_once __DIR__ . '/IImport.php';

class Pages implements IImport
{
	public $fromParents = array();

	public $fromLanguages = array();

	private $categoriesImport;



	public function __construct($categoriesImport)
	{
		$this->categoriesImport = $categoriesImport;
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

		$pages = $dibi->select("t.*, a.mail")->from("text t")
			->where("t.parent in %in and t.lng in %in", $this->fromParents, $this->fromLanguages)
			->and("t.secret = 0")
			->leftJoin("author a")->on("(a.id = t.author)")
			->fetchAll();

		$urls = array();
		$categoriesMap = $this->categoriesImport->getImportedMap();

		foreach ($pages as $page) {
			if ($page->author === 2 || !$page->author) {
				$author = null;
			} else {
				$author = \Nette\Environment::getService('UserService')->findOneByMail($page->mail);
			}

			$category = $categoriesMap[$page->parent];

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

			$em->persist($pageEntity);

			echo "Page " . $pageEntity->getName() . " imported.\n";
		}

		$em->flush();
		echo "Pages imported.";
	}

}