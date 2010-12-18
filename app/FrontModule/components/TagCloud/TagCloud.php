<?php

namespace KladnoMinule\Control;

/**
 * TagCloud control
 *
 * @author Jan Marek
 */
class TagCloud extends \Neuron\BaseControl
{
	/** @var string */
	public $sortClass = "alphabetical";

	/** @var string */
	public $destination;

	/** @var array */
	private $data;

	/** @var int */
	private $minOccurs;

	/** @var int */
	private $maxOccurs;

	/** @var int */
	protected $minWeight = 1;

	/** @var int */
	protected $maxWeight = 5;

	/**
	 * Data setter
	 * @param array $data data
	 */
	public function setData(array $data)
	{
		$this->data = $data;

		$occurs = array_map(function ($tag) {
			return $tag->getItemCount();
		}, $data);

		$this->maxOccurs = max($occurs);
		$this->minOccurs = min($occurs);
	}



	/**
	 * Data getter
	 * @return array data
	 */
	public function getData()
	{
		return $this->data;
	}



	/**
	 * Count weight
	 * @param int $currentOccurences
	 * @return int
	 */
	protected function countDistribution($currentOccurences)
	{
		$weight = (log($currentOccurences) - log($this->minOccurs))
		/ (log($this->maxOccurs) - log($this->minOccurs));

		$distribution = $this->minWeight + round($weight * ($this->maxWeight - $this->minWeight));

		return $distribution;
	}



	/**
	 * Get CSS class name
	 * @param int $distribution
	 * @return string
	 */
	protected function getCssClass($distribution)
	{
		return str_repeat('v', $distribution - $this->minWeight) . ($distribution > $this->minWeight ? '-' : '') . 'popular';
	}



	/**
	 * Render tag cloud
	 */
	public function render()
	{
		if (empty($this->data)) {
			return;
		}

		foreach ($this->data as $tag) {
			$distribution = $this->countDistribution($tag->getItemCount());

			$tags[] = (object) array(
				"name" => $tag->getName(),
				"class" => $this->getCssClass($distribution),
				"url" => $this->getPresenter()->link($this->destination, array(
					'id' => $tag->getId(),
				)),
			);
		}

		$template = $this->getTemplate();
		$template->tags = $tags;
		$template->sortClass = $this->sortClass;
		$template->destination = $this->destination;
		$template->render();
	}
}