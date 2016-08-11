<?php


require_once __DIR__ . '/../bootstrap.php';


use Code\Sistema\Services\ClienteService;
use Code\Sistema\Services\ProdutoService;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$app['clienteService'] = function () use ($em) {

    return new ClienteService($em);
};

$app['produtoService'] = function () use ($em){

    return new ProdutoService($em);
};



$app->get('/', function () use ($app){
    return $app['twig']->render('index.twig', []);
})->bind('index');

//////// cliente//////
// search
$app->get('cliente/search', function () use ($app){

    $params = [];
    if(isset($_SERVER['QUERY_STRING'])) {
        $query = $_SERVER['QUERY_STRING'];
    }else{
        $query = "s=&p=&l=";
    }
    parse_str($query, $params);
    $result = $app['clienteService']->search($params);
    return $app['twig']->render('clientes/list.twig', ['clientes'=>$result]);
})->bind('cliente/search');

//////// produto//////
// search
$app->get('produto/search', function () use ($app){

    $params = [];
    if(isset($_SERVER['QUERY_STRING'])) {
        $query = $_SERVER['QUERY_STRING'];
    }else{
        $query = "s=&p=&l=";
    }
    parse_str($query, $params);
    $result = $app['produtoService']->search($params);
    return $app['twig']->render('produtos/list.twig', ['produtos'=>$result]);
})->bind('produto/search');

/** API
 * 
 */

/////// cliente /////////
// Insert
$app->post('/api/cliente', function (Request $request) use ($app) {
    $dados = [
        "nome"=> $request->get("nome"),
        "email"=> $request->get("email")
    ];
    $result = $app['clienteService']->insert($dados);
    return $app->json($result);
});

// Delete
$app->delete('/api/cliente/{id}', function ($id) use ($app) {

    $result = $app['clienteService']->delete($id);
    return $app->json($result);
});

// Update
$app->post('/api/cliente/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome"=> $request->get("nome"),
        "email"=> $request->get("email")
    ];
    $result = $app['clienteService']->update($id, $dados);

    return $app->json($result);
});

// search
$app->get('api/cliente/search', function () use ($app){

    $params = [];
    if(isset($_SERVER['QUERY_STRING'])) {
        $query = $_SERVER['QUERY_STRING'];
    }else{
        $query = "s=&p=&l=";
    }
    parse_str($query, $params);
    $result = $app['clienteService']->search($params);
    return $app->json($result);
});

// Find
$app->get('api/cliente/{id}', function ($id) use ($app) {
    $result = $app['clienteService']->find($id);
    return $app->json($result);
});

// Fetch all
$app->get('api/cliente', function () use ($app) {
    $result = $app['clienteService']->fecthAll();
    return $app->json($result);
});



/////////// produto /////////
// Insert
$app->post('/api/produto', function (Request $request) use ($app) {
    $dados = [
        "nome"=> $request->get("nome"),
        "descricao"=> $request->get("descricao"),
        "valor"=> $request->get("valor")
    ];
    $result = $app['produtoService']->insert($dados);
    return $app->json($result);
});

// Delete
$app->delete('/api/produto/{id}', function ($id) use ($app) {

    $result = $app['produtoService']->delete($id);
    return $app->json($result);
});

// Update
$app->post('/api/produto/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome"=> $request->get("nome"),
        "descricao"=> $request->get("descricao"),
        "valor"=> $request->get("valor")
    ];
    $result = $app['produtoService']->update($id, $dados);

    return $app->json($result);
});

// Fetch
$app->get('api/produto/{id}', function ($id) use ($app) {
    $result = $app['produtoService']->fecth($id);
    return $app->json($result);
});

// Fetch all
$app->get('api/produto', function () use ($app) {
    $result = $app['produtoService']->fecthAll();
    return $app->json($result);
});

/*$app->error(function (\Exception $e, $code) use ($app) {
    return new Response("invalid call", $code);
});*/


$app->run();