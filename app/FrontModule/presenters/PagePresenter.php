<?php

namespace KladnoMinule\Presenter\FrontModule;

use Nette\Image;

/**
 * Page presenter
 *
 * @author Jan Marek
 */
class PagePresenter extends FrontPresenter
{
	public function actionDefault($id)
	{
		$page = $this->getService("PageService")->getPublishedArticleById($id);
		$this->template->page = $page;
		$this->template->title = $page->name;
		$this->template->description = $page->description;

		if ($page->getCommentsAllowed()) {
			$this['comments']->setCommentGroup($page->getComments());
		}

		$this['gallery']->setPage($page);
	}



	public function actionPhotos($id, $gallery, $photo)
	{
		$page = $this->getService("PageService")->getPublishedArticleById($id);
		$galleryEntity = $this->getService("PhotogalleryService")->find($gallery);
		$photoEntity = $this->getService("PhotoService")->find($photo);
		$this->template->page = $page;
		$this->template->title = $page->getName() . " - fotogalerie " . $galleryEntity->getName();
		$this->template->total = $galleryEntity->getPhotos()->count();
		$this->template->current = $galleryEntity->getPhotos()->indexOf($photoEntity) + 1;
		$this->template->gallery = $galleryEntity;
		$this->template->photo = $photoEntity;
		$this['comments']->setCommentGroup($photoEntity->getComments());
	}



	protected function createComponentComments($name)
	{
		new \Neuron\Control\Comments($this, $name);
	}



	protected function createComponentGallery($name)
	{
		new \KladnoMinule\Control\GalleryContainer($this, $name);
	}

}