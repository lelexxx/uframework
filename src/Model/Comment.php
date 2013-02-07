<?php

/** 
* @file Comment.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt
*/

Namespace Model;

class Comment
{
	private $id;
	
	private $idLocation;
	
	private $userName;
	
	private $body;
	
	private $createdAt;
	
	/**
	*
	* @param id int
	* @param userName String
	* @param createdAt DateTime|NULL
	*/
	public function __construct($id, $idLocation, $userName, $body, DateTime $createdAt = NULL)
	{
		$this->id = $id;
		$this->idLocation = $idLocation;
		$this->userName = $userName;
		$this->body = $body;
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
	
	/** To get the id.
	*
	* @return int
	*/
	public function getIdLocation()
	{
		return $this->idLocation;
	}
	
	/** To set the id.
	*
	* @param int
	*/
	public function setIdLocation($idLocation)
	{
		$this->idLocation = $idLocation;
	}
	
	/** To get the userName.
	*
	* @return String
	*/
	public function getUserName()
	{
		return $this->userName;
	}
	
	/** To set the userName.
	*
	* @param String
	*/
	public function setUserName($userName)
	{
		$this->userName = $userName;
	}
	
	/** To get the body.
	*
	* @return String
	*/
	public function getBody()
	{
		return $this->body;
	}
	
	/** To set the body.
	*
	* @param String
	*/
	public function setBody($body)
	{
		$this->body = $body;
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
	
	/** To test if the comment is new
	*
	*@return boolean
	*/
	public function isNew()
	{
		if(null === $this->id)
			return true;
			
		return false;
	
	}
}
