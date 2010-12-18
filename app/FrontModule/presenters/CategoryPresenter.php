<?php

namespace KladnoMinule\Presenter\FrontModule;

/**
 * Category presenter
 *
 * @author Jan Marek
 */
class CategoryPresenter extends FrontPresenter
{

	public function renderDefault($id)
	{
		$category = $this->getService('CategoryService')->find($id);
		$this->template->title = $category->getName();
		$this->template->articles = $this->getService('PageService')->getPublishedArticles()->whereCategory($category)->getResult();
	}



	protected function createComponentArticles($name)
	{
		$control = new \KladnoMinule\Control\ArticleList($this, $name);
		$control->setShowCategory(false);
	}
}
