<?php

namespace KladnoMinule\Presenter\FrontModule;

/**
 * Homepage presenter
 *
 * @author Jan Marek
 */
class HomepagePresenter extends FrontPresenter
{
	public function renderDefault()
	{
		$articles = $this->getService('PageService')->getPublishedArticles()->getLimitedResult(7);
		$this->template->newestArticles = $articles;
	}



	protected function createComponentNewestArticles($name)
	{
		$list = new \KladnoMinule\Control\ArticleList($this, $name);
		$list->disablePaginator();
	}

}
