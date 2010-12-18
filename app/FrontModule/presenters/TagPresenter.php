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
		$this->template->articles = $this->getService('PageService')->getPublishedArticles()->whereTag($tag)->getResult();
	}



	protected function createComponentArticles($name)
	{
		new \KladnoMinule\Control\ArticleList($this, $name);
	}
}
