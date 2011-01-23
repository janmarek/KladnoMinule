<?php

namespace KladnoMinule\Form;

/**
 * Register form
 *
 * @author Jan Marek
 */
class RegisterForm extends \Neuron\Form\BaseForm
{
	protected function addFields()
	{
		$this->addText('name')
			->setRequired('Vyplňte jméno.');

		$this->addText('mail')
			->setRequired('Vyplňte e-mail')
			->addRule(self::EMAIL, 'Vyplňte e-mail správně.');

		$this->addPassword('password')
			->setRequired('Vyplňte heslo.');

		$this->addPassword('password2')
			->setRequired('Vyplňte heslo pro kontrolu ještě jednou.')
			->addRule(self::EQUAL, 'Vyplňte hesla stejně.', $this['password']);
	}



	protected function handler($values)
	{
		try {
			$this->getService('UserService')->register(array(
				'name' => $values['name'],
				'mail' => $values['mail'],
				'password' => $values['password'],
			));

			$this->presenter->flashMessage('Pro dokončení registrace zkontrolujte svou e-mailovou schránku a následujte pokyny v potvrzovacím e-mailu.');
			$this->presenter->redirect('Homepage:');
		} catch (\Nette\Security\AuthenticationException $e) {
			$this->addError($e->getMessage());
		}
	}

}