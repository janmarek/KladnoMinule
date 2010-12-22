<?php

namespace KladnoMinule\Import;

use Neuron\Model\Comment\Comment;

require_once __DIR__ . '/IImport.php';

class Comments extends AbstractImport
{
	private $usersImport;

	private $pagesImport;



	public function __construct($usersImport, $pagesImport)
	{
		$this->usersImport = $usersImport;
		$this->pagesImport = $pagesImport;
	}



	public function clear(\Doctrine\ORM\EntityManager $em)
	{
		$em->createQuery('delete Neuron\Model\Comment\Comment c')->execute();
		echo "Comments deleted.\n";
	}



	public function init(\Doctrine\ORM\EntityManager $em)
	{

	}



	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em)
	{
		echo "Started importing comments.\n";

		$res = $dibi->select("*")->from('comment')->execute();
		$res->setType('date', \dibi::DATETIME);
		$res->setType('author', \dibi::INTEGER);
		$res->setType('parent', \dibi::INTEGER);
		$comments = $res->fetchAll();

		$usersMap = $this->usersImport->getImportedMap();
		$pagesMap = $this->pagesImport->getImportedMap();

		foreach ($comments as $comment) {
			if (empty($pagesMap[$comment->parent])) {
				continue;
			}

			$author = $usersMap[$comment->author];

			$commentEntity = new Comment(array(
				'author' => $author,
				'text' => $comment->text_texy,
			));
			$em->persist($commentEntity);

			$this->setPrivateValue($commentEntity, 'created', $comment->date);

			$pagesMap[$comment->parent]->getComments()->addComment($commentEntity);
			echo ".";
		}

		$em->flush();
		echo "\nComments imported.\n";
	}

}