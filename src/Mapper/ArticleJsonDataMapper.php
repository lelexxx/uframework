<?php

/** 
* @file ArticleJsonDataMapper.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>
*/

namespace Mapper;

class ArticleJsonDataMapper implements DataMapperInterface
{
	
	/** Contruct
	* 
	*/ 
	public function __construct()
	{
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
	
	/** Delete an article from the file.
	*
	*@param $article Article
	*
	*@return array
	*/
	public function remove($article)
	{
	}
	
	/** Insert an article in the file.
	*
	*@param $article Article
	*
	*@return
	*/
	public function insert($article)
	{
	}
	
	/** Update an article in the file.
	*
	*@param $article Article
	*
	*@return array
	*/
	public function update($article)
	{
	}
}
