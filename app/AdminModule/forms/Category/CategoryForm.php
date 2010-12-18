<?php

namespace KladnoMinule\Form;

/**
 * Category form
 *
 * @author Jan Marek
 */
class CategoryForm extends \Neuron\Form\EntityForm
{
	protected function addFields()
	{
		$this->addText("name");
		$this->addTextArea("description");
	}
}