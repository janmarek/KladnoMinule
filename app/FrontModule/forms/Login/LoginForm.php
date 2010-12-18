<?php

namespace KladnoMinule\Form;

/**
 * Login form
 *
 * @author Jan Marek
 */
class LoginForm extends \Neuron\Form\BaseForm
{
	protected function addFields()
	{
		$this->addText('mail')
			->setRequired('Vyplňte e-mail.');

		$this->addPassword('password')
			->setRequired('Vyplňte heslo.');
	}



	protected function handler($values)
	{
		try {
			$this->getUser()->login($values['mail'], $values['password']);

			$this->presenter->flashMessage("Přihlášení bylo úspěšné.");
			$this->presenter->redirect('this');
		} catch (\Nette\Security\AuthenticationException $e) {
			$this->addError($e->getMessage());
		}
	}

}