<?php

/** 
* @file ArticleDataMapper.php
*/

namespace Mapper;

class ArticleDataMapper implements PersistenceInterface, FinderInterface
{
    /** Name of the table */
    private $tableName = "articles";
    
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
    
    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll() {
        
    }

<<<<<<< HEAD
    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id) {
        
    }
=======
		return $this->database->executeQuery($query, array(
			'name' => $article->getName(),
			'description' => $article->getDescription()));
	}
	
	/** Update an article in the database.
	*
	*@param $location Article
	*
	*@return array
	*/
	public function update($article)
	{
		$query = 'UPDATE articles 
				  SET name = :name, description = :description
				  WHERE id = :id';
>>>>>>> 560d50e476f1695f2c2d0d770ad07723490a82ec

    /** Render an article peristante
    *
    *@param $article Article
    *
    *@return array
    */
    public function persist($article)
    {
            if($article->isNew()){
                    return $this->insert($article);
            }

            return $this->update($article);
    }

    /** Delete an article from the database.
    *
    *@param $article Article
    *
    *@return array
    */
    public function remove($article)
    {
            $query = 'DELETE FROM '.$this->tableName.' WHERE id = :id';

            return $this->database->executeQuery($query, array(
                    'id' => $article->getId()));
    }

    /** Insert an article in the database.
    *
    *@param $location Article
    *
    *@return
    */
    public function insert($article)
    {
            $query = 'INSERT INTO '.$this->tableName.' (id, name, description) 
                              VALUES ( null, :name, :description)';

            return $this->database->executeQuery($query, array(
                    'name' => $article->getName(),
                    'description' => $article->getDescription()));
    }

    /** Update an article in the database.
    *
    *@param $location Article
    *
    *@return array
    */
    public function update($article)
    {
            $query = 'UPDATE '.$this->tableName.' 
                              SET name = :name, description = :description
                              WHERE id = :id';

            return $this->database->executeQuery($query, array(
                    'id' => $article->getId(),
                    'name' => $article->getName(),
                    'descrption' => $article->getDescription()));
    } 
}
