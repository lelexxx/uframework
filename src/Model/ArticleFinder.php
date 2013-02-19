<?php

/** 
* @file Locations.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>
*/

namespace Model;

class ArticleFinder implements FinderInterface, PersistenceInterface
{	
	private $datafile;
	
	private $articles = array();

	/** Collection of locations. */
	protected $locations = array();
	
	public function __construct($datafile = '/../../data/article.txt')
	{		
		$this->datafile = __DIR__.''.$datafile;
		
		$array = $this->getArrayWithJson();
		
		foreach($array as $id => $articleName)
				$this->articles[] = new Article($id, $articleName);
	}
	
	/** Add a location.
	*
	* @param mixed $value
	*/
	public function create($value)
	{
		$this->articles[] = new Article(count($this->locations), $value);

		$this->saveOnJson();
	}
	
	/** Delete a location by its id.
	*
	* @param mixed $id
	*/
	public function delete($id)
	{		
		unset($this->locations[$id]);
		$this->articles = array_values($this->locations);
		
		$this->saveOnJson();
	}
	
	/** Return all elements.
	*
	*@return array
	*/
	public function findAll()
	{
		return $this->articles;
	}
	
	/** Retrieve an element by its id.
	*
	* @param mixed $id
	* @return null|mixed
	*/
	public function findOneById($id)
	{
		return $this->articles[$id]; 
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
		$array = array();
		
		foreach($this->articles as $id => $location)
				$array[] = $location->getName();
				
		return json_encode($array);
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
		$this->articles[$id]->setName($value);
		
		$this->saveOnJson();
	}
}