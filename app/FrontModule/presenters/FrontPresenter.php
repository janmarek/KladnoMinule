<?php

namespace KladnoMinule\Presenter\FrontModule;

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
}
