<?php

namespace KladnoMinule\Control;

/**
 * PhotoGalleryContainer
 *
 * @author Jan Marek
 */
class PhotoGalleryContainer extends \Neuron\BaseControl
{
	protected function createComponent($id)
	{
		$service = $this->getService('PhotogalleryService');
		$gallery = new \Neuron\PhotogalleryAdmin;
		$gallery->setGallery($service->find($id));
		return $gallery;
	}

	public function render($gallery)
	{
		$this[$gallery->getId()]->render();
	}
}