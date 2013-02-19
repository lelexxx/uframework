<?php

/** La classe Database (Base de données) permet de faire le lien entre le site et la base de données.
*
* @file Database.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>
*/

namespace DAL;

class DataBase extends \PDO

{		
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
