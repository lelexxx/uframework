<?php

/** 
* @file FinderInterface.php
*
* @author Muetton Julien, Durand William
*/

namespace Model;

interface FinderInterface
{
    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll();

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id);
}
