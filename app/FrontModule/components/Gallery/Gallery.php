<?php

namespace KladnoMinule\Control;

/**
 * Photos
 *
 * @author Jan Marek
 */
class Gallery extends \Neuron\BaseControl
{
	private $enablePaginator = true;

	private $gallery;

	private $page;



	public function render()
	{
		$photos = $this->getService('PhotoService')->getFinder()->whereGallery($this->gallery)->orderByOrder();
		$paginator = $this["paginator"]->getPaginator();
		$paginator->setItemCount($photos->count());
		$this->template->photos = $photos->getPaginatedResult($paginator);
		$this->template->page = $this->page;
		$this->template->gallery = $this->gallery;
		$this->template->showPaginator = $this->enablePaginator;
		$this->template->render();
	}



	public function enablePaginator()
	{
		$this->enablePaginator = true;
	}



	public function disablePaginator()
	{
		$this->enablePaginator = false;
	}



	protected function createComponentPaginator($name)
	{
		$paginator = new \Neuron\Control\Paginator($this, $name);
		$paginator->getPaginator()->setItemsPerPage(18);
	}



	public function setGallery($gallery)
	{
		$this->gallery = $gallery;
	}



	public function getGallery()
	{
		return $this->gallery;
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
