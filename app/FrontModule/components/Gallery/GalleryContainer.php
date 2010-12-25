<?php

namespace KladnoMinule\Control;

/**
 * GalleryContainer
 *
 * @author Jan Marek
 */
class GalleryContainer extends \Neuron\BaseControl
{
	private $page;



	protected function createComponent($name)
	{
		$galleryControl = new Gallery($this, $name);
		$galleryControl->setGallery($this->getService('PhotogalleryService')->find($name));
		$galleryControl->setPage($this->page);
	}


	public function render($gallery)
	{
		$this->getComponent($gallery->getId())->render();
	}



	public function setPage($page)
	{
		$this->page = $page;
	}



	public function getPage()
	{
		return $this->page;
	}

}
