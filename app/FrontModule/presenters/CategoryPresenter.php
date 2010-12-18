<?php

namespace KladnoMinule\Presenter\FrontModule;

/**
 * Category presenter
 *
 * @author Jan Marek
 */
class CategoryPresenter extends \Neuron\Presenter\FrontModule\HomepagePresenter
{

	public function renderDefault($id)
	{
		$category = $this->getService('CategoryService')->find($id);
		$this->template->title = $category->getName();
		$this->template->articles = $this->getService('PageService')->getFinder()->whereAllowed()->whereCategory($category)->getResult();
	}
}
