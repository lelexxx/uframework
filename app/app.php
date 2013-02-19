<?php

require __DIR__ . '/../autoload.php';

use Http\Request;
use Model\ArticleFinder;
use Exception\HttpException;

// Config
$debug = true;

$app = new \App(new \View\TemplateEngine(__DIR__ . '/templates/'), $debug);

/**
 * Index
 */
$app->get('/', function () use ($app)
	{
		return $app->redirect('/articles');
	});

// Récupère la liste des articles
$app->get('/articles', function(Request $request) use ($app)
	{
		$model = new ArticleFinder();
		$art = $model->findAll();
		
		return $app->render('articles.php', array("articles" => $art));
	});
	
//Récupère une article
$app->get('/articles/(\d+)', function(Request $request, $id) use ($app)
	{
		$model = new ArticleFinder();
		$art = $model->findOneById($id);
		
		if(null === $art){
			throw new HttpException(404, "Article not found");
		}

		return $app->render('article.php', array("id" => $id, "article" => $art));
	});
	
//Ajoute une article
$app->post('/articles', function(Request $request) use ($app)
	{
		$articleName = $request->getParameter('articleName', null);
		
		if(null === $articleName){
			throw new HttpException(400, "Name parameter is mandatory !");
		}
		
		$articleContent = $request->getParameter('articleContent', null);
		
		if(null === $articleContent){
			throw new HttpException(400, "Content parameter is mandatory !");
		}
			
		$model = new ArticleFinder();
		$model->create($articleName);
		
		$app->redirect('/articles');
	});
	
//Supprime une article
$app->delete('/articles/(\d+)', function(Request $request, $id) use ($app)
	{
		$model = new ArticleFinder();
		$art = $model->findOneById($id);
		
		if(null === $art){
			throw new HttpException(404, "Article not found");
		}

		$model->delete($id);
		
		$app->redirect('/articles');
	});
	
//Met à jour une article
$app->put('/articles/(\d+)', function(Request $request, $id) use ($app)
	{
		$model = new ArticleFinder();
		$art = $model->findOneById($id);
		
		if(null === $art){
			throw new HttpException(404, "Article not found");
		}
		
		$articleName = $request->getParameter('articleName', $art->getName());
		$articleContent = $request->getParameter('articleContent', $art->getContent());

		$model->update($id, $articleName);
		$art = $model->findOneById($id);

		return $app->render('article.php', array("id" => $id, "article" => $art));
	});

//Accès à l'administration
$app->get('/adminSite', function(Request $request) use ($app)
	{
		return $app->render('admin.php', array());
	});

return $app;
