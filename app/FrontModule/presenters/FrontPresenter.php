<?php

namespace KladnoMinule\Presenter\FrontModule;

use Neuron\Control\Feed;
use Nette\Environment;

/**
 * Front presenter
 *
 * @author Jan Marek
 */
abstract class FrontPresenter extends \Neuron\Presenter\FrontModule\HomepagePresenter
{
	protected function createComponentTagCloud($name)
	{
		$tagCloud = new \KladnoMinule\Control\TagCloud($this, $name);
		$tagCloud->destination = ':Front:Tag:default';
		$tagCloud->setData($this->getService('TagService')->getUsedTags());
	}



	protected function createComponentLoginForm()
	{
		return new \KladnoMinule\Form\LoginForm;
	}



	protected function createComponentRss($name)
	{
		$feed = new Feed($this, $name);
		$feed->cacheOptions = array(
			'tags' => array('KladnoMinule\Model\Page\Page')
		);
		$feed->fileName = 'rss.xml';
		$feed->folderPath = WWW_DIR;
		$feed->folderUri = Environment::getVariable('baseUri');
		$feed->setLinkTitle('Kladno minulé');
		$feed->setTitle('Kladno minulé');
		$feed->setDescription('Nové články na webu Kladno minulé.');
		$feed->setLink($this->link('//Homepage:'));

		$presenter = $this;

		$feed->onLoadData[] = function () use ($feed, $presenter) {
			$pages = $presenter->getService('PageService')->getPublishedArticles()->getLimitedResult(10);

			foreach ($pages as $page) {
				$feed->addItem(array(
					'title' => $page->getName(),
					'pubDate' => $page->getCreated(),
					'description' => $page->getDescription(),
					'link' => $presenter->link('//Page:', $page->getId()),
				));
			}
		};
	}
}