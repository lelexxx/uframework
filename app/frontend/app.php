<?php

//Use
use Http\Request;
use Mapper\ArticleJsonDataMapper;
use Exception\HttpException;

// Config
$debug = true;
$urlRoot = '/uframework'; //Define root of THIS website
$app = new \App(new \View\TemplateEngine(__DIR__ . '/templates/'), $urlRoot, $debug);

//Define routes which don't require authentification
$app->addListener('process.before', function(Request $req) use ($app, $urlRoot) {
    session_start();

    $allowed = [
        $urlRoot.'/' => [ Request::GET ],
        $urlRoot.'/login' => [ Request::GET ],
        $urlRoot.'/accessAdmin' => [ Request::GET ],
        $urlRoot.'/articles' => [ Request::GET ],
        $urlRoot.'/articles/(\d+)' => [ Request::GET ],
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
    
    throw new HttpException(401, 'Access denied !');
});

//Index
$app->get('/', function () use ($app){
    return $app->redirect('/articles');
});

// Get article list
$app->get('/articles', function() use ($app){
    $mapper = new ArticleJsonDataMapper();
    $art = $mapper->findAll();

    return $app->render('articles.php', array("articles" => $art), 'layout.php');
});
	
//Get one article with its id
$app->get('/articles/(\d+)', function(Request $request, $id) use ($app){
    $model = new ArticleJsonDataMapper();
    $art = $model->findOneById($id);

    if(null === $art){
        throw new HttpException(404, "Article not found");
    }

    return $app->render('article.php', array("id" => $id, "article" => $art));
});
	
//Access to the login form
$app->get('/login', function() use ($app){
    return $app->render('login.php');
});
	
//Access to the login form
$app->get('/accessAdmin', function(Request $request) use ($app){
    $login = $request->getParameter('login', null);
    $password = $request->getParameter('password', null);

    if(null === $login){
        throw new HttpException(400, "Login is mandatory !");
    }

    if(null === $password){
        throw new HttpException(400, "Password is mandatory !");
    }

    if($login !== $password){
        $app->redirect('/login');
    }

    session_start();
    $_SESSION['is_authenticated'] = true;

    $app->redirect('/admin');
});
	
return $app;
