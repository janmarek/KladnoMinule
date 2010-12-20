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



	public function actionProfile($id)
	{
		$user = $this->service->find($id);
		$this->template->person = $user;
		$this->template->title = 'Uživatel ' . $user->getName();
		$articles = $this->getService('PageService')->getPublishedArticles()->whereAuthor($user);
		$paginator = $this["articles"]["paginator"]->getPaginator();
		$paginator->setItemCount($articles->count());
		$paginator->setItemsPerPage(6);
		$this->template->articles = $articles->getPaginatedResult($paginator);
		$this['sendMailForm']->setTo($user->getMail());
	}



	public function actionFinishRegistration($hash)
	{
		try {
			$user = $this->service->activateUser($hash);
			$this->flashMessage('Uživatel je aktivován a registrace byla úspěšně dokončena.');
			$this->redirect("Homepage:");

		} catch (\KladnoMinule\Model\User\UserNotFoundException $e) {
			$this->flashMessage('Uživatel nebyl nalezen. Možná již byl aktivován.', 'error');
		}
	}



	protected function createComponentArticles($name)
	{
		$control = new \KladnoMinule\Control\ArticleList($this, $name);
		$control->setShowAuthor(false);
	}



	protected function createComponentRegisterForm($name)
	{
		new \KladnoMinule\Form\RegisterForm($this, $name);
	}



	protected function createComponentSendMailForm($name)
	{
		$form = new \KladnoMinule\Form\SendMailForm($this, $name);
		$form->setFrom($this->getUser()->getIdentity()->mail, $this->getUser()->getIdentity()->name);
		$form->setSuccessFlashMessage("E-mail byl úspěšně odeslán.");
		$form->setRedirect("this");
	}



	protected function createComponentLostPasswordForm($name)
	{
		$form = new \KladnoMinule\Form\LostPasswordForm($this, $name);
		$form['mail']->setDefaultValue($this->getParam('mail', ''));

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
