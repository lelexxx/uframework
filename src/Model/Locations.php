<?php

/** 
* @file Locations.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>, Muetton Julien, Durand William
*/

namespace Model;

class Locations implements FinderInterface, PersistenceInterface
{	
	private $datafile;
	
	private $database;

	/** Collection of locations. */
	protected $locations = array();//0 => "Totoland", 1 => "San Francisco", 2 => "Babooland");
	
	public function __construct(Database $database)
	{
		$this->datafile = __DIR__."/../../data/locations.txt";
		$this->database = $database;
		
		$array = $this->getArrayWithJson();
		
		if(!empty($array)){
			$this->locations = $array;
		}
	}
	
	/** Add a location.
	*
	* @param mixed $value
	*/
	public function create($value)
	{
		$this->locations[] = $value;

		$this->saveOnJson();
	}
	
	/** Delete a location by its id.
	*
	* @param mixed $id
	*/
	public function delete($id)
	{		
		unset($this->locations[$id]);
		$this->locations = array_values($this->locations);
		
		$this->saveOnJson();
	}
	
	/** Return all elements.
	*
	*@return array
	*/
	public function findAll()
	{
		return $this->locations;
		/* array loc = new array();
		foreach($locations as $id => locationName)
			loc[] = new Location($id, $this->locations[$id]);
		endforeach;*/
	}
	
	/** Retrieve an element by its id.
	*
	* @param mixed $id
	* @return null|mixed
	*/
	public function findOneById($id)
	{
		return $this->locations[$id]; 
		//return new Location($id, $this->locations[$id]);
	}

	/** Get the location in array format by a json format.
	*
	* @return array 
	*/
	public function getArrayWithJson()
	{
		$json = json_decode(file_get_contents($this->datafile));
		
		return $json;
	}
	
	/** Get the location in JSon format.
	*
	* @return String 
	*/
	public function getJson()
	{
		return json_encode($this->locations);
	}
	
	/** Save the locations in a file, on JSon format
	*
	*/
	public function saveOnJson()
	{
		$locJson = $this->getJson();

		$fp = fopen ($this->datafile, "w+");  
		fputs($fp, $locJson);  
		fclose($fp);  
	}
	
	/** Update a location by its id
	*
	* @param mixed $id
	* @param mixed $value
	*/
	public function update($id, $value)
	{
		$this->locations[$id] = $value;
		
		$this->saveOnJson();
	}
}
