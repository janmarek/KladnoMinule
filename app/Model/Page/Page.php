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

	/** @ManyToOne(targetEntity="KladnoMinule\Model\User\User") */
	private $author;

	/** @OneToOne(targetEntity="Neuron\Model\Comment\CommentGroup", cascade={"all"}) */
	private $comments;

	/** @Column(type="boolean") */
	private $commentsAllowed = true;

	/** @OneToOne(targetEntity="Neuron\Model\Photo\Gallery", cascade={"all"}) */
	private $photogallery;

	/** @ManyToOne(targetEntity="KladnoMinule\Model\Category\Category") */
	private $category;

	/** @ManyToMany(targetEntity="KladnoMinule\Model\Tag\Tag") */
	private $tags;



	public function __construct(array $values = array())
	{
		parent::__construct($values);
		$this->created = new DateTime;
		$this->photogallery = new \Neuron\Model\Photo\Gallery;
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



	public function getPhotogallery()
	{
		return $this->photogallery;
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


}