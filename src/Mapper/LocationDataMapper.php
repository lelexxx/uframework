<?php

/** 
* @file LocationDataMapper.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt
*/

namespace Mapper;

class LocationDataMapper implements DataMapperInterface
{
	/** DataBase access */
	private $database;
	
	/** Contruct
	* 
	* @param $database Database Data Access Layer
	*/ 
	public function __construct(\Dal\DataBase $database)
	{
		$this->database = $database;
	}
	
	/** Render a location peristante
	*
	*@param $location Location
	*
	*@return array
	*/
	public function persist($location)
	{
		if($location->isNew())
			return $this->insert($location);
			
		return $this->update($location);
	}
	
	/** Delete a location from the database.
	*
	*@param $location Location
	*
	*@return array
	*/
	public function remove($location)
	{
		$query = 'DELETE FROM locations WHERE id = :id';

		return $this->database->executeQuery($query, array(
			'id' => $location->getId()));
	}
	
	/** Insert a location in the database.
	*
	*@param $location Location
	*
	*@return
	*/
	public function insert($location)
	{
		$query = "INSERT INTO locations (id, name, createdAt) 
			  VALUES ( null, :name, :createdAt)";
				  
	  	if($location->getCreatedAt() != null){
			$createdAt = $location->getCreatedAt()->format('Y-m-d H:i:s');
		}
		else{
			$createdAt = null;
		}

		return $this->database->executeQuery($query, array(
			'name' => $location->getName(),
			'createdAt' => $createdAt));
	}
	
	/** Update a location in the database.
	*
	*@param $location Location
	*
	*@return array
	*/
	public function update($location)
	{
		$query = 'UPDATE locations 
				  SET name = :name, createdAt = :createdAt
				  WHERE id = :id';

		if($location->getCreatedAt() != null){
			$createdAt = $location->getCreatedAt()->format('Y-m-d H:i:s');
		}
		else{
			$createdAt = null;
		}

		return $this->database->executeQuery($query, array(
			'id' => $location->getId(),
			'name' => $location->getName(),
			'createdAt' => $createdAt));
	}
}
