<?php

/** 
* @file ArticleFinder.php
*/

namespace Model;

class ArticleFinder implements FinderInterface, PersistenceInterface
{	
    private $datafile;

    /** Collection of articles. */
    protected $articles = array();

    public function __construct($datafile = '/../../data/article.txt'){		
        $this->datafile = __DIR__.''.$datafile;

        $array = $this->getArrayWithJson();

        foreach($array as $id => $article){
                $this->articles[] = new Article($id, $article[0]["name"], $article[1]["description"]);
        }
    }

    /** Add a article.
    *
    * @param mixed $value
    */
    public function create($value){
        $this->articles[] = new Article(count($this->articles), $value);

        $this->saveOnJson();
    }

    /** Delete a article by its id.
    *
    * @param mixed $id
    */
    public function delete($id){		
        unset($this->articles[$id]);
        $this->articles = array_values($this->articles);

        $this->saveOnJson();
    }

    /** Return all elements.
    *
    *@return array
    */
    public function findAll(){
        return $this->articles;
    }

    /** Retrieve an element by its id.
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
        $json = json_decode(file_get_contents($this->datafile), true);

        return $json;
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

    /** Save the articles in a file, on JSon format
    *
    */
    public function saveOnJson(){
        $articleJson = $this->getJson();

        $fp = fopen ($this->datafile, "w+");  
        fputs($fp, $articleJson);  
        fclose($fp);  
    }

    /** Update a article by its id
    *
    * @param mixed $id
    * @param mixed $value
    */
    public function update($id, $value){
        $this->articles[$id]->setName($value);

        $this->saveOnJson();
    }
}
