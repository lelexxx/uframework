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
$app->addListener('process.before', function(Request $req) use ($urlRoot) {
    session_start();

    $allowed = [
        $urlRoot.'/' => [ Request::GET ],
        $urlRoot.'/login' => [ Request::GET ],
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
    
    throw new HttpException(401);
});

//Index
$app->get('/', function () use ($app){
    return $app->redirect('/articles');
});

// Get article list
$app->get('/admin/articles', function() use ($app){
    $mapper = new ArticleJsonDataMapper();
    $art = $mapper->findAll();

    return $app->render('articles.php', array("articles" => $art));
});
	
//Get one article with its id
$app->get('/admin/articles/(\d+)', function(Request $request, $id) use ($app){
    $model = new ArticleJsonDataMapper();
    $art = $model->findOneById($id);

    if(null === $art){
        throw new HttpException(404, "Article not found");
    }

    return $app->render('article.php', array("id" => $id, "article" => $art));
});
	
//Add an article
$app->post('/admin/articles', function(Request $request) use ($app){
    $articleName = $request->getParameter('name', null);

    if(null === $articleName){
        throw new HttpException(400, "Name parameter is mandatory !");
    }

    $articleDescription = $request->getParameter('description', null);

    if(null === $articleDescription){
        throw new HttpException(400, "Content parameter is mandatory !");
    }

    $mapper = new ArticleJsonDataMapper();
    $mapper->persist(new Article(null, $articleName, $articleDescription));

    $app->redirect('/admin/articles');
});
	
//Delete an article
$app->delete('/admin/articles/(\d+)', function(Request $request, $id) use ($app){
    $model = new ArticleJsonDataMapper();
    $art = $model->findOneById($id);

    if(null === $art){
        throw new HttpException(404, "Article not found");
    }

    $model->remove($id);

    $app->redirect('/admin/articles');
});
	
//Update an article
$app->put('/admin/articles/(\d+)', function(Request $request, $id) use ($app){
    $mapper = new ArticleJsonDataMapper();
    $art = $mapper->findOneById($id);

    if(null === $art){
        throw new HttpException(404, "Article not found");
    }

    $art->setName($request->getParameter('articleName', $art->getName()));
    $art->setDescription($request->getParameter('articleContent', $art->getDescription()));

    $mapper->persist($art);

    return $app->render('backend/article.php', array("id" => $id, "article" => $art));
});
	
//Access to the administration
$app->get('/admin', function() use ($app){
    return $app->render('admin.php', array());
});

return $app;
