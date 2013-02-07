<?php

/** 
* @file Locations.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt Muetton Julien, Durand William
*/


namespace Model;

class LocationFinder implements FinderInterface
{	
	/** DataBase access */
	private $database;

	/** Collection of locations. */
	protected $locations = array();
	
	public function __construct(\Dal\DataBase $database)
	{
		$this->database = $database;
	}
	
	/** Get a location from the database by its id.
	*
	*@param $id int
	*
	*@return Location
	*/
	public function findOneById($id)
	{
		$query = 'SELECT * FROM locations WHERE id = :id';

		$loc = $this->database->executeQuery($query, array(
					'id' => $id))[0];
		
		return new Location($loc->id, $loc->name, array(), $loc->createdAt);
	}
	
	/** Get all locations from the database.
	*
	*@return Array
	*/
	public function findAll()
	{
		$locations = array();
		$query = 'SELECT * FROM locations';

		$allLocations = $this->database->executeQuery($query);
		
		foreach ($allLocations as $loc){
		  $locations[] = new Location($loc->id, $loc->name, array(), $loc->createdAt);
		}
		
		return $locations;
	}
}
