<?php

/** 
* @file ArticleDataMapper.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>
*/

namespace Mapper;

class ArticleDataMapper implements DataMapperInterface
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
		$query = 'DELETE FROM articles WHERE id = :id';

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
		$query = 'INSERT INTO articles (id, name, description) 
				  VALUES ( null, :name, :description)';

		return $this->database->executeQuery($query, array(
			'name' => $article->getName(),
			'createdAt' => $article->getDescription()));
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

		return $this->database->executeQuery($query, array(
			'id' => $article->getId(),
			'name' => $article->getName(),
			'descrption' => $article->getDescription()));
	}
}
