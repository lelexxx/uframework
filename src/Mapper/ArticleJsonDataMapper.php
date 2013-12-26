<?php

namespace Mapper;

use Model\Article;

class ArticleJsonDataMapper implements FinderInterface, PersistenceInterface
{	
     /** Path of JSON file where store data */
    private $datafile;

    /** Collection of articles. */
    private $articles = array();

    /** Construct
    *
    * @param String $datafile
    */
    public function __construct($datafile = '/../../data/article.json'){		
        $this->datafile = __DIR__.''.$datafile;

        $array = $this->getArrayWithJson();
		
        foreach($array->articles as $article){
            $this->articles[$article->id] = new Article($article->id, $article->name, $article->description);
        }
    }

    /** Add a article.
    *
    * @param Article $value
    */
    public function insert($article){
        $this->articles[$article->getId()] = $article;

        $this->saveOnJson();
    }

    /** Return all articles.
    *
    *@return array
    */
    public function findAll($criterias = null){
		return $this->articles;
    }

    /** Retrieve an article by its id.
    *
    * @param mixed $id
    * @return null|mixed
    */
    public function findOneById($id){
		return $this->articles[$id]; 
    }

    /** Get the article in array format by a json format.
    *
    * @return array 
    */
    public function getArrayWithJson(){
		return json_decode(file_get_contents($this->datafile));
    }

    /** Get the article in JSon format.
    *
    * @return String 
    */
    public function getJson(){
        $array = array();

        foreach($this->articles as $id => $article){
			$array[] = $article->getName();
        }

        return json_encode($array);
    }
    
    /** Check if an article is new or has to be update
     * 
     * @param \Mapper\Article $article
     * @return type
     */
    public function persist($article){
        if($article->isNew()){
            return $this->insert($article);
        }
        
        return $this->update($article);
    }

    /** Save the articles in a file, on JSon format
    *
    */
    public function saveOnJson(){
        $articleJson = $this->getJson();

        $fp = fopen ($this->datafile, "w+");  
        fputs($fp, $articleJson);  
        fclose($fp);  
    }
    
    /** Delete an article by its id.
    *
    * @param mixed $id
    */
    public function remove($id){		
        unset($this->articles[$id]);

        $this->saveOnJson();
    }
	
    /** Update an article by its id
    *
    * @param mixed $id
    * @param mixed $value
    */
    public function update($article){
        $articleToUpdate = $this->articles[$article->getId()];
        $articleToUpdate->setName($article->getName());
        $articleToUpdate->setDescription($article->getDescription());
		
		$this->articles[$article->getId()] = $articleToUpdate;

        $this->saveOnJson();
    }
}