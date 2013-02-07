<?php

require __DIR__ . '/../autoload.php';

use Http\Request;
use DAL\DataBase;
use Mapper\LocationDataMapper;
use Mapper\CommentDataMapper;
use Model\Comment;
use Model\Location;
use Model\LocationFinder;
use Model\CommentFinder;
use Exception\HttpException;

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
		$model = new LocationFinder($database);
		$loc = $model->findAll();
		
		return $app->render('locations.php', array("locations" => $loc));
	});
	
//Récupère une location
$app->get('/locations/(\d+)', function(Request $request, $id) use ($app, $database)
	{
		$locationMapper = new LocationFinder($database);
		$loc = $locationMapper->findOneById($id);
		
		if(NULL === $loc){
			throw new HttpException(404, "Location not found");
		}
		
		$commentMapper = new CommentFinder($database);
		$loc->setComments($commentMapper->findAllByIdLocation($loc->getId()));

		return $app->render('location.php', array("id" => $id, "location" => $loc));
	});
	
//Ajoute une location
$app->post('/locations', function(Request $request) use ($app, $database)
	{
		if(empty($_POST['locationName'])){
			throw new HttpException(400, "Name parameter is mandatory !");
		}
			
		$model = new LocationDataMapper($database);
		$model->persist(new Location(null, $_POST['locationName']));
		
		$app->redirect('/locations');
	});
	
//Supprime une location
$app->delete('/locations/(\d+)', function(Request $request, $id) use ($app, $database)
	{
		$model = new LocationFinder($database);
		$loc = $model->findOneById($id);
		
		if(NULL === $loc){
			throw new HttpException(404, "Location not found");
		}

		$mapper = new LocationDataMapper($database);
		$mapper->remove($loc);
		
		$app->redirect('/locations');
	});
	
//Met à jour une location
$app->put('/locations/(\d+)', function(Request $request, $id) use ($app, $database)
	{
		$model = new LocationFinder($database);
		$loc = $model->findOneById($id);
		
		if(NULL === $loc){
			throw new HttpException(404, "Location not found");
		}
			
		if(empty($_POST['locationName'])){
			throw new HttpException(400, "Name parameter is mandatory !");
		}

		$mapper = new LocationDataMapper($database);
		$mapper->update(new Location($_POST['locationId'], $_POST['locationName']));
		
		$loc = $model->findOneById($id);

		return $app->render('location.php', array("id" => $id, "location" => $loc, "comments" => array()));
	});
	
//Ajoute un commentaire
$app->post('/comments', function(Request $request) use ($app, $database)
	{
		if(empty($_POST['commentBody'])){
			throw new HttpException(400, "Body parameter is mandatory !");
		}
		
		if(empty($_POST['userName'])){
			throw new HttpException(400, "User name parameter is mandatory !");
		}
		
		if(empty($_POST['locationId'])){
			throw new HttpException(400, "Id location is mandatory !");
		}
			
		$mapper = new CommentDataMapper($database);
		$mapper->persist(new Comment(null, $_POST['locationId'], $_POST['userName'], $_POST['commentBody']));
		
		//$app->redirect('/locations/'.$_POST['locationId']);
	});

return $app;
