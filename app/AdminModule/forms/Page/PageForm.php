<?php

namespace KladnoMinule\Form;

/**
 * Page form
 *
 * @author Jan Marek
 */
class PageForm extends \Neuron\Form\EntityForm
{
	protected function addFields()
	{
		$this->addText("name");
		$this->addText("url")
			->setAttribute("class", "url")
			->setAttribute("rel", $this["name"]->htmlId);
		$this->addText("description");
		$this->addTextArea("text")
			->setAttribute("class", "texyla");
		$this->addCheckbox("allowed");
		$this->addDatePicker("created");
		$this->addCheckbox("commentsAllowed");
		$this->addSelect("author", null, $this->getService('UserService')->getDictionary())->skipFirst('Bez autora');
		$this->addSelect("category", null, $this->getService('CategoryService')->getDictionary());
		$this->addMultiSelect("tags", null, $this->getService('TagService')->getDictionary(), 10);
	}
}