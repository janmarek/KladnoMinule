<?php

namespace KladnoMinule\Presenter\FrontModule;

/**
 * User presenter
 *
 * @author Jan Marek
 */
class UserPresenter extends FrontPresenter
{
	/** @var KladnoMinule\Model\User\Service */
	private $service;



	protected function startup()
	{
		parent::startup();
		$this->service = $this->getService('UserService');
	}



	public function renderProfile($id)
	{
		$user = $this->service->find($id);
		$this->template->person = $user;
		$this->template->title = 'Uživatel ' . $user->getName();
		$this->template->articles = $this->getService('PageService')->getPublishedArticles()->whereAuthor($user)->getResult();
	}



	protected function createComponentArticles($name)
	{
		$control = new \KladnoMinule\Control\ArticleList($this, $name);
		$control->setShowAuthor(false);
	}



	protected function createComponentLostPasswordForm($name)
	{
		new \KladnoMinule\Form\LostPasswordForm($this, $name);
	}



	protected function createComponentNewPasswordForm($name)
	{
		$form = new \KladnoMinule\Form\NewPasswordForm($this, $name);
		$form->setDefaults(array(
			'mail' => $this->getParam('mail'),
			'hash' => $this->getParam('hash'),
		));
	}



}
