<?php

require __DIR__ . '/../autoload.php';

use Http\Request;
use Model\Locations;
use Exception\HttpException;
use Mode\Database

// Config
$debug = true;

$app = new \App(new \View\TemplateEngine(__DIR__ . '/templates/'), $debug);
$database = Database::getMysqlInstance();

/**
 * Index
 */
$app->get('/', function () use ($app)
	{
		return $app->redirect('/locations');
	});

// Récupère la liste des locations
$app->get('/locations', function(Request $request) use ($app)
	{
		$model = new Locations($database);
		$loc = $model->findAll();
		
		return $app->render('locations.php', array("locations" => $loc));
	});
	
//Récupère une location
$app->get('/locations/(\d+)', function(Request $request, $id) use ($app)
	{
		$model = new Locations($database);
		$loc = $model->findOneById($id);
		
		if(NULL === $loc)
			throw new HttpException(404, "Location not found"); //si elle existe pas on emet une exception


		return $app->render('location.php', array("id" => $id, "location" => $loc));
		//return $app->render('location.php', array("location" => $loc));
	});
	
//Ajoute une location
$app->post('/locations', function(Request $request) use ($app)
	{
		if(empty($_POST['locationName'])) //$request->getParamter('name')
			throw new HttpException(400, "Name parameter is mandatory !"); //si elle existe pas on emet une exception
			
		$model = new Locations($database);
		$model->create($_POST['locationName']); //on ajoute la location
		
		$app->redirect('/locations'); //nouvelle méthode de redirection
	});
	
//Supprime une location
$app->delete('/locations/(\d+)', function(Request $request, $id) use ($app)
	{
		$model = new Locations($database);
		$loc = $model->findOneById($id); //on regarde si la location existe
		
		if(NULL === $loc)
			throw new HttpException(404, "Location not found"); //si elle existe pas on emet une exception

		$model->delete($id); //on l'a supprime
		
		$app->redirect('/locations'); //nouvelle méthode de redirection
	});
	
//Met à jour une location
$app->put('/locations/(\d+)', function(Request $request, $id) use ($app)
	{
		$model = new Locations($database);
		$loc = $model->findOneById($id); //on regarde si la location existe
		
		if(NULL === $loc){
			throw new HttpException(404, "Location not found"); //si elle existe pas on emet une exception
		}
			
		if(empty($_POST['locationName'])){ //$request->getParamter('name')
			throw new HttpException(400, "Name parameter is mandatory !"); //si elle existe pas on emet une exception
		}

		$model->update($_POST['locationId'], $_POST['locationName']); //met à jour la location
		$loc = $model->findOneById($id); //on récupère la location MAJ

		return $app->render('location.php', array("id" => $id, "location" => $loc));
	});

return $app;
