<?php

namespace KladnoMinule\Presenter\FrontModule;

/**
 * Tag presenter
 *
 * @author Jan Marek
 */
class TagPresenter extends FrontPresenter
{

	public function renderDefault($id)
	{
		$tag = $this->getService('TagService')->find($id);
		$this->template->title = $tag->getName();
		$articles = $this->getService('PageService')->getPublishedArticles()->whereTag($tag);
		$paginator = $this["articles"]["paginator"]->getPaginator();
		$paginator->setItemCount($articles->count());
		$this->template->articles = $articles->getPaginatedResult($paginator);
	}



	protected function createComponentArticles($name)
	{
		new \KladnoMinule\Control\ArticleList($this, $name);
	}
}
