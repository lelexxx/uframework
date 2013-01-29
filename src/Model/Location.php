<?php

/** 
* @file Location.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>
*/

namespace Model;

class Location
{
	private $id;
	
	private $name;
	
	private $createdAt;
	
	/**
	*
	* @param id int
	* @param name String
	* @param createdAt DateTime|NULL
	*/
	public function __construct($id, $name, DateTime $createdAt = null)
	{
		$this->id = $id;
		$this->name = $name;
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
}
