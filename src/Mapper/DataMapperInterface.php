<?php

/** 
* @file DataMapperInterface.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com> && Mathieu Valcourt
*/

namespace Mapper;

interface DataMapperInterface
{
	/** Delete an object from the database.
	*
	*@param $object Object
	*
	*@return array
	*/
	public function remove($object);
	
	/** Insert an object in the database.
	*
	*@param $object Object
	*
	*@return
	*/
	public function insert($object);
	
	/** Update a object in the database.
	*
	*@param $object Object
	*
	*@return array
	*/
	public function update($object);
}
