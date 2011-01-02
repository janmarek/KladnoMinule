<?php

namespace KladnoMinule\Form;

/**
 * User form
 *
 * @author Jan Marek
 */
class UserForm extends \Neuron\Form\EntityForm
{
	protected function addFields()
	{
		$this->addText("name");
		$this->addText("mail");
		$this->addSelect("role", null, array(
			"admin" => "admin",
			"user" => "user",
			"author" => "author",
		))->setDefaultValue("user");
		$this->addCheckbox("active");
		$this->addText("password");
	}
}