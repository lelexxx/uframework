<?php

require __DIR__ . '/../autoload.php';

use Http\Request;
use Model\Locations;
use Exception\HttpException;
use Model\Database;

// Config
$debug = true;

$app = new \App(new \View\TemplateEngine(__DIR__ . '/templates/'), $debug);
$database = new Database();

/**
 * Index
 */
$app->get('/', function () use ($app)
	{
		return $app->redirect('/locations');
	});

// Récupère la liste des locations
$app->get('/locations', function(Request $request) use ($app, $database)
	{
		$model = new Locations($database);
		$loc = $model->findAll();
		
		return $app->render('locations.php', array("locations" => $loc));
	});
	
//Récupère une location
$app->get('/locations/(\d+)', function(Request $request, $id) use ($app, $database)
	{
		$model = new Locations($database);
		$loc = $model->findOneById($id);
		
		if(NULL === $loc){
			throw new HttpException(404, "Location not found");
		}

		return $app->render('location.php', array("id" => $id, "location" => $loc));
	});
	
//Ajoute une location
$app->post('/locations', function(Request $request) use ($app, $database)
	{
		if(empty($_POST['locationName'])){
			throw new HttpException(400, "Name parameter is mandatory !");
		}
			
		$model = new Locations($database);
		$model->create($_POST['locationName']);
		
		$app->redirect('/locations');
	});
	
//Supprime une location
$app->delete('/locations/(\d+)', function(Request $request, $id) use ($app, $database)
	{
		$model = new Locations($database);
		$loc = $model->findOneById($id);
		
		if(NULL === $loc){
			throw new HttpException(404, "Location not found");
		}

		$model->delete($id);
		
		$app->redirect('/locations');
	});
	
//Met à jour une location
$app->put('/locations/(\d+)', function(Request $request, $id) use ($app, $database)
	{
		$model = new Locations($database);
		$loc = $model->findOneById($id);
		
		if(NULL === $loc){
			throw new HttpException(404, "Location not found");
		}
			
		if(empty($_POST['locationName'])){
			throw new HttpException(400, "Name parameter is mandatory !");
		}

		$model->update($_POST['locationId'], $_POST['locationName'])
		$loc = $model->findOneById($id);

		return $app->render('location.php', array("id" => $id, "location" => $loc));
	});

return $app;
