<?php

/** 
* @file TemplateEngineInterface.php
*
* @author Muetton Julien, Durand William
*/

namespace View;

interface TemplateEngineInterface
{
    public function render($template, array $parameters = array());
}
