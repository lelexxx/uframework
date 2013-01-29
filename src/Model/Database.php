<?php

/** La classe Database (Base de donn�es) permet de faire le lien entre le site et la base de donn�es.
* Elle respect le design pattern (patron de conception) Singleton.
*
* @file Database.class.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>
*/

namespace Model;

class DataBase extends PDO
{
	/** L'instance unique de la base. */
	private static $instanceDataBase = NULL;
	
	/** le chemin vers le serveur. */
	private $hote = 'localhost';
	
	/** le nom de votre base de donn�es. */
	private $port = '';
	
	/** le nom de la ase de donn�es. */
	private $database_name = 'uframework';
	
	/** nom d'utilisateur pour se connecter. */
	private $database_user = 'uframework';
	
	/** mot de passe de l'utilisateur pour se connecter. */
	private $database_password = 'uframework123';	
	
	/** Constructeur.
	*
	* @param string $sgdb_type Le type de la base de donn�es utilis�e.
	* 
	* @see PDO::__construct()
	*/
	private function __construct($sgdb_type)
	{		
		$dsn = $sgdb_type.':host='.$this->hote.';dbname='.$this->database_name;
		
		parent::__construct($dsn, $this->user, $this->password);
	}
	
	/** Cr�e et retourne l'objet DataBase.
	*
	* @static
	*
	* @param string $sgdb_type Le type de la base de donn�es utilis�e.
	*
	* @return DataBase $instanceDataBase Retourne l'instance unique de la classe.
	*/
	public static function getInstance($sgdb_type)
	{
		if(is_null(self::$instanceDataBase))
		{
			self::$instanceDataBase = new Database($sgdb_type);
		}
		
		return self::$instanceDataBase;
	}
	
	/** Cr�e et retourne l'objet DataBase pour une base de donn�es Mysql.
	*
	* @static
	*
	* @return DataBase $instanceDataBase Retourne l'instance unique de la classe.
	*/
	public static function getMysqlInstance()
	{
		if(is_null(self::$instanceDataBase))
		{
			self::$instanceDataBase = new Database('mysql');
		}
		
		return self::$instanceDataBase;
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
