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

		if ($page->getCommentsAllowed()) {
			$this['comments']->setCommentGroup($page->getComments());
		}
	}


	protected function createComponentComments($name)
	{
		new \Neuron\Control\Comments($this, $name);
	}

}