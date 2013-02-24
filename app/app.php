<?php

require __DIR__ . '/../autoload.php';

//Use
use Http\Request;
use Model\ArticleFinder;
use Exception\HttpException;

// Config
$debug = true;
$app = new \App(new \View\TemplateEngine(__DIR__ . '/templates/'), $debug);

//Define routes which don't require authentification
$app->addListener('process.before', function(Request $req) use ($app) {
    session_start();

    $allowed = [
		'/' => [ Request::GET ],
        '/login' => [ Request::GET ],
        '/articles' => [ Request::GET ],
        '/articles/(\d+)' => [ Request::GET ],
    ];

    if (isset($_SESSION['is_authenticated']) && true === $_SESSION['is_authenticated']){
        return;
    }

    foreach ($allowed as $pattern => $methods) {
        if (preg_match(sprintf('#^%s/?$#', $pattern), $req->getUri()) && in_array($req->getMethod(), $methods)) {
            return;
        }
    }

    switch ($req->guessBestFormat()) {
        case 'json':
            throw new HttpException(401);
    }
    
    throw new HttpException(401);
});

//Index
$app->get('/', function () use ($app){
		return $app->redirect('/articles');
	});

// Get article list
$app->get('/articles', function(Request $request) use ($app){
		$model = new ArticleFinder();
		$art = $model->findAll();
		
		return $app->render('articles.php', array("articles" => $art));
	});
	
//Get one article with its id
$app->get('/articles/(\d+)', function(Request $request, $id) use ($app){
		$model = new ArticleFinder();
		$art = $model->findOneById($id);
		
		if(null === $art){
			throw new HttpException(404, "Article not found");
		}

		return $app->render('article.php', array("id" => $id, "article" => $art));
	});
	
//Add an article
$app->post('/articles', function(Request $request) use ($app){
		$articleName = $request->getParameter('articleName', null);
		
		if(null === $articleName){
			throw new HttpException(400, "Name parameter is mandatory !");
		}
		
		$articleContent = $request->getParameter('articleContent', '');
		
		if(null === $articleContent){
			throw new HttpException(400, "Content parameter is mandatory !");
		}
			
		$model = new ArticleFinder();
		$model->create(new Article(null, $articleName, $articleContent));
		
		$app->redirect('/articles');
	});
	
//Delete an article
$app->delete('/articles/(\d+)', function(Request $request, $id) use ($app){
		$model = new ArticleFinder();
		$art = $model->findOneById($id);
		
		if(null === $art){
			throw new HttpException(404, "Article not found");
		}

		$model->delete($id);
		
		$app->redirect('/articles');
	});
	
//Update an article
$app->put('/articles/(\d+)', function(Request $request, $id) use ($app){
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

//Access to the login form
$app->get('/login', function(Request $request) use ($app){
		return $app->render('login.php', array());
	});
	
//Access to the administration
$app->get('/admin', function(Request $request) use ($app){
		$login = $request->getParameter('login', null);
		$password = $request->getParameter('password', null);
		
		if(null === $login){
			throw new HttpException(400, "Login is mandatory !");
		}
		
		if(null === $password){
			throw new HttpException(400, "Password is mandatory !");
		}
		
		return $app->render('admin.php', array());
	});

return $app;
