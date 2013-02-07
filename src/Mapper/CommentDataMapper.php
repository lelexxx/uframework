<?php

/** 
* @file CommentDataMapper.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt
*/

namespace Mapper;

class CommentDataMapper implements DataMapperInterface
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
	
	/** Render a comment peristante
	*
	*@param $comment Comment
	*
	*@return array
	*/
	public function persist($comment)
	{
		if($comment->isNew())
			return $this->insert($comment);
			
		return $this->update($comment);
	}
	
	/** Delete a comment from the database.
	*
	*@param $comment Comment
	*
	*@return array
	*/
	public function remove($comment)
	{
		$query = 'DELETE FROM comments WHERE id = :id';

		return $this->database->executeQuery($query, array(
			'id' => $comment->getId()));
	}
	
	/** Insert a comment in the database.
	*
	*@param $comment Comment
	*
	*@return
	*/
	public function insert($comment)
	{
		$query = 'INSERT INTO comments (id, idLocation, userName, body , createdAt)
				  VALUES("", :idLocation, :userName, :body, :createdAt)';
				  
	  	if($comment->getCreatedAt() != null){
			$createdAt = $comment->getCreatedAt()->format('Y-m-d H:i:s');
		}
		else{
			$createdAt = null;
		}

		return $this->database->executeQuery($query, array(
			'idLocation' => $comment->getIdLocation(),
			'userName' => $comment->getUserName(),
			'body' => $comment->getBody(),
			'createdAt' => $createdAt));
	}
	
	/** Update a comment in the database.
	*
	*@param $comment Comment
	*
	*@return array
	*/
	public function update($comment)
	{
		$query = 'UPDATE comments 
				  SET userName = :userName, body = :body, createdAt = :createdAt
				  WHERE id = :id';

		return $this->database->executeQuery($query, array(
			'id' => $comment->getId(),
			'userName' => $comment->getUserName(),
			'body' => $comment->getBody(),
			'createdAt' => $createdAt));
	}
}
