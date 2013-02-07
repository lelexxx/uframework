<?php

/** 
* @file Locations.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt Muetton Julien, Durand William
*/

use \DAL\DataBase;

namespace Model;

class CommentFinder implements FinderInterface
{	
	/** DataBase access */
	private $database;
	
	public function __construct(\Dal\DataBase $database)
	{
		$this->database = $database;
	}
	
	/** Get a comment from the database by its id.
	*
	*@param $id int
	*
	*@return Comment
	*/
	public function findOneById($id)
	{
		$query = 'SELECT * FROM comments WHERE id = :id';

		$com = $this->database->executeQuery($query, array(
					'id' => $id))[0];
		
		return new Comment($com->id, $com->userName, $com->body, $com->createdAt);
	}
	
	/** Get all comments from the database.
	*
	*@return Array
	*/
	public function findAll()
	{
		$comments = array();
		$query = 'SELECT * FROM comments';

		$allComments = $this->database->executeQuery($query);
		
		foreach ($allComments as $com){
			$comments[] = new Comment($com->id, $com->userName, $com->body, $com->createdAt);
		}
		
		return $comments;
	}
	
	/** Get all comment from the database by id location.
	*
	*@param $id int
	*
	*@return array
	*/
	public function findAllByIdLocation($idLocation)
	{
		$query = 'SELECT * FROM comments WHERE idLocation = :idLocation';

		$allComments = $this->database->executeQuery($query, array(
					'idLocation' => $idLocation));
		
		$comments = array();
		
		foreach ($allComments as $com){
			$comments[] = new Comment($com->id, $com->idLocation, $com->username, $com->body, $com->createdAt);
		}
		
		return $comments;
	}
}
