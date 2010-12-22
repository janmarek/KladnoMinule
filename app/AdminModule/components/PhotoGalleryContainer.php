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
		$gallery = new \Neuron\PhotogalleryAdmin($this, $id);
		$gallery->setGallery($service->find($id));
		$gallery['grid']->setAjaxClass("nic");
	}

	public function render($gallery)
	{
		$this[$gallery->getId()]->render();
	}
}