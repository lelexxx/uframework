<?php

/** 
* @file ArticleJsonDataMapper.php
*/

namespace Mapper;

class ArticleJsonDataMapper implements PersistenceInterface
{
	
    /** Contruct
    * 
    */ 
    public function __construct(){
    }

    /** Render an article peristante
    *
    *@param $article Article
    *
    *@return array
    */
    public function persist($article){
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
    public function remove($article){
    }

    /** Insert an article in the file.
    *
    *@param $article Article
    *
    *@return
    */
    public function insert($article){
    }

    /** Update an article in the file.
    *
    *@param $article Article
    *
    *@return array
    */
    public function update($article){
    }
}
