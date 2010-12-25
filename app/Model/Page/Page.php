<?php

namespace KladnoMinule\Model\Page;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Page entity
 *
 * @author Jan Marek
 *
 * @Entity
 * @Table(name="page")
 */
class Page extends \Neuron\Model\Page\Page
{
	/** @Column(type="datetime") */
	private $created;

	/** @Column(type="float", nullable=true) */
	private $lat;

	/** @Column(type="float", nullable=true) */
	private $lng;

	/** @ManyToOne(targetEntity="KladnoMinule\Model\User\User") */
	private $author;

	/** @OneToOne(targetEntity="Neuron\Model\Comment\CommentGroup", cascade={"all"}) */
	private $comments;

	/** @Column(type="boolean") */
	private $commentsAllowed = true;

	/** @ManyToMany(targetEntity="Neuron\Model\Photo\Gallery", cascade={"all"}) */
	private $photogalleries;

	/** @ManyToOne(targetEntity="KladnoMinule\Model\Category\Category") */
	private $category;

	/** @ManyToMany(targetEntity="KladnoMinule\Model\Tag\Tag") */
	private $tags;



	public function __construct(array $values = array())
	{
		$this->created = new DateTime;
		parent::__construct($values);
		$this->photogalleries = new ArrayCollection;
		$this->comments = new \Neuron\Model\Comment\CommentGroup;
		$this->tags = new ArrayCollection;
	}



	public function setAuthor($author)
	{
		$this->author = $author;
	}



	public function getAuthor()
	{
		return $this->author;
	}



	public function setCategory($category)
	{
		$this->category = $category;
	}



	public function getCategory()
	{
		return $this->category;
	}



	public function getComments()
	{
		return $this->comments;
	}



	public function setCommentsAllowed($commentsAllowed)
	{
		$this->commentsAllowed = $commentsAllowed;
	}



	public function getCommentsAllowed()
	{
		return $this->commentsAllowed;
	}



	public function setCreated($created)
	{
		$this->created = $created;
	}



	public function getCreated()
	{
		return $this->created;
	}



	public function getPhotogalleries()
	{
		return $this->photogalleries;
	}



	public function addPhotogallery()
	{
		$this->photogalleries->add(new \Neuron\Model\Photo\Gallery);
	}



	public function setTags($tags)
	{
		if (is_array($tags)) {
			$tags = new ArrayCollection($tags);
		}

		foreach ($this->tags as $tag) {
			if (!$tags->contains($tag)) {
				$tag->decrease();
			}
		}

		foreach ($tags as $tag) {
			if (!$this->tags->contains($tag)) {
				$tag->increase();
			}
		}

		$this->tags = $tags;
	}



	public function getTags()
	{
		return $this->tags;
	}



	public function setLat($lat)
	{
		$this->lat = $lat;
	}



	public function getLat()
	{
		return $this->lat;
	}



	public function setLng($lng)
	{
		$this->lng = $lng ?: null;
	}



	public function getLng()
	{
		return $this->lng ?: null;
	}

}