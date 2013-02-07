<?php

/** La classe Database (Base de données) permet de faire le lien entre le site et la base de données.
* Elle respect le design pattern (patron de conception) Singleton.
*
* @file Database.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt
*/

namespace DAL;

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
		
		parent::__construct($dsn, $this->database_user, $this->database_password);
	}
	
	/**
     * @param string $query
     * @param array  $parameters
     *
     * @return bool Returns `true` on success, `false` otherwise
     */
    public function executeQuery($query, $parameters = array())
    {
    	try
    	{
		$stmt = $this->prepare($query);
	
		foreach ($parameters as $name => $value)
		{
		    $stmt->bindValue(':'.$name, $value);
		}

		$stmt->execute();
        }
        catch(SqlException $e)
        {
		throw new SqlException(500, "Mysql error");
        }
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
