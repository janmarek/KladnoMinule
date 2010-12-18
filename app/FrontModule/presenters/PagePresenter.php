<?php

namespace KladnoMinule\Presenter\FrontModule;

/**
 * Page presenter
 *
 * @author Jan Marek
 */
class PagePresenter extends FrontPresenter
{
	public function actionDefault($id)
	{
		$page = $this->getService("PageService")->getPublishedArticles()->whereId($id)->getSingleResult();
		$this->template->page = $page;
		$this->template->title = $page->name;
		$this->template->description = $page->description;
	}

}