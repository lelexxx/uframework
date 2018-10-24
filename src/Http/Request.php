<?php

/** 
* @file Request.php
*/

namespace Http;

class Request
{
    const GET    = 'GET';
    const POST   = 'POST';
    const PUT    = 'PUT';
    const DELETE = 'DELETE';

    private $parameters = array();

    /** Create an instance of Request.
    * 
    */
    public static function createFromGlobals(){
		return new self($_GET, $_POST);
    }

    /** Construct of the class
    * 
    * @param $query array GET parameters
    * @param $request array POST parameters
    *
    */
    public function __construct(array $query = array(), array $request = array()){
        $this->parameters = array_merge($query, $request);
    }

    /** Get the current method
    *
     * @return string HTTP method
    */
    public function getMethod(){
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : self::GET;

        if (self::POST === $method){
            return $this->getParameter('_method', $method); //retourne la vrai méthode
        }

        return $method;
    }

    /** Get parameter for the HTTP Request
    *
    * @param $name string the name of the parameter
    * @param $default string the default value if $name is not found.
    *
     * @return string corresponding value to the $name key or $default value
    */
    public function getParameter($name, $default = null){
        if(!array_key_exists($name, $this->parameters)){
            return $default;
        }

        return $this->parameters[$name];
    }

    /**
    * @return string the current request URI
    */
    public function getUri(){
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        if ($pos = strpos($uri, '?')){
            $uri = substr($uri, 0, $pos);
        }

        return $uri;
    }

    /**
     * @return string the HTTP host
     */
    public function getHost(){
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    }

    /**
     *
     * @return bool is HTTPS protocol used
     */
    public function isHttps(){
        return isset($_SERVER['HTTPS']);
    }

    /**
    * @return string Request's best format
    */
    public function guessBestFormat(){
        return 'text/html';
    }
}
