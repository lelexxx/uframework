<?php

/** La classe Database (Base de données) permet de faire le lien entre le site et la base de données.
* Elle respect le design pattern (patron de conception) Singleton.
*
* @file Database.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>
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
		//$dsn = $sgdb_type.':host='.$this->hote.';dbname='.$this->database_name;
		
		//parent::__construct($dsn, $this->user, $this->password);
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
