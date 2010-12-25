<?php

namespace KladnoMinule\Import;

use Neuron\Model\Comment\Comment;

require_once __DIR__ . '/IImport.php';

class Photos extends AbstractImport
{
	private $pagesImport;



	public function __construct($pagesImport)
	{
		$this->pagesImport = $pagesImport;
	}



	public function clear(\Doctrine\ORM\EntityManager $em)
	{
		$em->createQuery('delete Neuron\Model\Photo\Photo p')->execute();
		$em->createQuery('delete Neuron\Model\Photo\Gallery g')->execute();
		echo "Photos and galleries deleted.\n";
	}



	public function init(\Doctrine\ORM\EntityManager $em)
	{

	}



	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em)
	{
		echo "Started importing photos.\n";

		$res = $dibi->select("*")->from('photo')->execute();
		$res->setType('gallery', \dibi::INTEGER);
		$res->setType('parent', \dibi::INTEGER);
		$photos = $res->fetchAssoc('parent,gallery,#');

		$originalRoot = __DIR__ . "/../../kladno/photos";

		$pagesMap = $this->pagesImport->getImportedMap();

		$repository = \Nette\Environment::getService("PhotoRepository");

		foreach ($photos as $pageId => $pages) {
			foreach ($pages as $galleryId => $galleries) {
				$gallery = new \Neuron\Model\Photo\Gallery;
				$em->persist($gallery);

				$first = true;

				foreach ($galleries as $photo) {
					$file = $originalRoot . "/" . $photo->filename . ".jpg";

					if (empty($pagesMap[$photo->parent])) {
						echo "\n  warning - $photo->filename import failed.\n";
						break;
						// todo warning
					}

					if ($first) {
						$pagesMap[$photo->parent]->getPhotogalleries()->add($gallery);
						$first = false;
					}

					$hash = $repository->save(file_get_contents($file));
					$photo = new \Neuron\Model\Photo\Photo(array(
						"hash" => $hash,
						'description' => $photo->description,
					));
					$em->persist($photo);
					$gallery->addPhoto($photo);

					echo ".";
				}
			}
		}

		$em->flush();
		echo "\nPhotos imported.\n";
	}

}