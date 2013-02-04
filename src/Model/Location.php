<?php

/** 
* @file Location.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt
*/

namespace Model;

class Location
{
	private $id;
	
	private $name;
	
	private $createdAt;
	
	private $comments = array();
	
	/**
	*
	* @param id int
	* @param name String
	* @param createdAt DateTime|NULL
	*/
	public function __construct($id, $name, array $comments = array(), DateTime $createdAt = null)
	{
		$this->id = $id;
		$this->name = $name;
		$this->comments = $comments;
		$this->createdAt = $createdAt;
	}
	
	/** To get the id.
	*
	* @return int
	*/
	public function getId()
	{
		return $this->id;
	}
	
	/** To set the id.
	*
	* @param int
	*/
	public function setId($id)
	{
		$this->id = $id;
	}
	
	/** To get the name.
	*
	* @return String
	*/
	public function getName()
	{
		return $this->name;
	}
	
	/** To set the name.
	*
	* @param String
	*/
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/** To get the createdAt field.
	*
	* @return DateTime
	*/
	public function getCreatedAt()
	{
		return $this->createdAt;
	}
	
	/** To set the createdAt field.
	*
	* @param DateTime
	*/
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
	}
	
	/** To get the comments.
	*
	* @return array
	*/
	public function getComments()
	{
		return $this->comments;
	}
	
	/** To set the comments.
	*
	* @param array
	*/
	public function setComments(array $comments)
	{
		$this->comments = $comments;
	}
	
	/** To test if the location is new
	*
	*@return boolean
	*/
	public function isNew()
	{
		if($this->id != null)
			return true;
			
		return false;
	}
}
