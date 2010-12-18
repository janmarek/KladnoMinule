<?php

namespace KladnoMinule\Presenter\AdminModule;

use Gridito\Grid;
use KladnoMinule\Form\CategoryForm;

/**
 * Category presenter
 *
 * @author Jan Marek
 */
class CategoryPresenter extends \Neuron\Presenter\AdminModule\AdminPresenter
{
	/** @var \Neuron\Model\Category\Service */
	private $service;



	public function startup()
	{
		parent::startup();
		$this->service = $this->getService("CategoryService");
	}



	public function renderDefault()
	{
		$this->template->title = "Kategorie";
	}



	public function actionAdd()
	{
		$this->template->title = "Přidat kategorii";
		$this["form"]->bindEntity($this->service->createBlank());
		$this["form"]->setSuccessFlashMessage("Kategorie byla přidána.");
	}



	public function actionEdit($id)
	{
		$entity = $this->service->find($id);
		$this->template->title = "Upravit $entity->name";
		$this["form"]->bindEntity($entity);
		$this["form"]->setSuccessFlashMessage("Kategorie byla upravena.");
	}



	protected function createComponentForm($name)
	{
		$form = new CategoryForm($this, $name);
		$form->setEntityService($this->service);
		$form->setRedirect("default");
	}



	protected function createComponentGrid($name)
	{
		$grid = new Grid($this, $name);
		$grid->setModel($this->service->getFinder()->getGriditoModel());

		$grid->addColumn("name", "Název")->setSortable(true);

		$presenter = $this;

		$grid->addButton("edit", "Upravit", array(
			"icon" => "ui-icon-pencil",
			"link" => function ($entity) use ($presenter) {
				return $presenter->link("edit", $entity->getId());
			},
		));

		$service = $this->service;

		$grid->addButton("delete", "Smazat", array(
			"icon" => "ui-icon-closethick",
			"handler" => function ($entity) use ($presenter, $service) {
				$service->delete($entity);
				$presenter->flashMessage("");
				$presenter->redirect("this");
			},
		));

		$grid->addToolbarButton("add", "Přidat", array(
			"icon" => "ui-icon-plusthick",
			"link" => $this->link("add"),
		));
	}
}