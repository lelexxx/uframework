<?php

/** La classe Database (Base de données) permet de faire le lien entre le site et la base de données.
* Elle respect le design pattern (patron de conception) Singleton.
*
* @file Database.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt
*/

namespace Model;

class DataBase extends \PDO

{	
	/** le chemin vers le serveur. */
	private $hote = 'localhost';
	
	/** le nom de votre base de données. */
	private $port = '';
	
	/** le nom de la ase de données. */
	private $database_name = 'uframework';
	
	/** nom d'utilisateur pour se connecter. */
	private $database_user = 'uframework';
	
	/** mot de passe de l'utilisateur pour se connecter. */
	private $database_password = 'uframework123';	
	
	/** Constructeur.
	*
	* @param string $sgdb_type Le type de la base de données utilisée.
	* 
	* @see PDO::__construct()
	*/
	public function __construct($sgdb_type = 'mysql')
	{		
		$dsn = $sgdb_type.':host='.$this->hote.';dbname='.$this->database_name;
		
		//parent::__construct($dsn, $this->user, $this->password);
	}
	
	/** Render a location peristante
	*
	*@param $location Location
	*
	*@return array
	*/
	public function persist(Location $location)
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
	public function remove(Location $location)
	{
		$query = 'DELETE FROM location WHERE id = :id';

		return $this->con->executeQuery($query, array(
			'id'    => $location->getId()));
	}
	
	/** Insert a location in the database.
	*
	*@param $location Location
	*
	*@return
	*/
	private function insert(Location $location)
	{
		$query = 'INSERT INTO location 
				  VALUES(name = :name, createdAt = :createdAt)';

		return $this->con->executeQuery($query, array(
			'name'  => $location->getName(),
			'createdAt'  => $location->getCreatedAt()));
	}
	
	/** Update a location in the database.
	*
	*@param $location Location
	*
	*@return array
	*/
	private function update(Location $location)
	{
		$query = 'UPDATE location 
				  SET name = :name, createdAt = :createdAt
				  WHERE id = :id';

		return $this->con->executeQuery($query, array(
			'id'    => $location->getId(),
			'name'  => $location->getName(),
			'createdAt'  => $location->getCreatedAt()));
	}
	
	/**
     * @param string $query
     * @param array  $parameters
     *
     * @return bool Returns `true` on success, `false` otherwise
     */
    public function executeQuery($query, $parameters = array())
    {
        $stmt = $this->prepare($query);

        foreach ($parameters as $name => $value) {
            $stmt->bindValue(':' . $name, $value);
        }

        return $stmt->execute();
    }
}
