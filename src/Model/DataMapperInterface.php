<?php

/** 
* @file DataMapperInterface.php
*
* @author Ruiz Alexandre <rruiz.alex@gmail.com>
*/

namespace Model;

interface DataMapperInterface
{
	public function persist(Object $object);
	
	public function remove(Object $object);
}
