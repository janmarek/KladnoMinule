<?php

namespace KladnoMinule\Presenter\FrontModule;

/**
 * HomepagePresenter
 *
 * @author Jan Marek
 */
class HomepagePresenter extends FrontPresenter
{

	public function renderDefault()
	{
		$this->template->newestArticles = $this->getService('PageService')->getFinder()->whereAllowed()->orderByDateDesc()->getLimitedResult(7);
	}
}
