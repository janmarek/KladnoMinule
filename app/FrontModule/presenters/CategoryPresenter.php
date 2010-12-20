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
		$articles = $this->getService('PageService')->getPublishedArticles()->whereCategory($category);
		$this->template->title = $category->getName();
		$paginator = $this["articles"]["paginator"]->getPaginator();
		$paginator->setItemCount($articles->count());
		$this->template->articles = $articles->getPaginatedResult($paginator);
	}



	protected function createComponentArticles($name)
	{
		$control = new \KladnoMinule\Control\ArticleList($this, $name);
		$control->setShowCategory(false);
	}
}
