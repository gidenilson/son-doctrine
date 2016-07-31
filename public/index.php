<?php


require_once __DIR__ . '/../bootstrap.php';

use Code\Sistema\Entities\Cliente;
use Code\Sistema\Mappers\ClienteMapper;
use Code\Sistema\Services\ClienteService;

use Code\Sistema\Entities\Produto;
use Code\Sistema\Mappers\ProdutoMapper;
use Code\Sistema\Services\ProdutoService;

use Symfony\Component\HttpFoundation\Request;


$app['clienteService'] = function () use ($em) {
    $client = new Cliente();
    $mapper = new ClienteMapper($em);

    return new ClienteService($client, $mapper);
};

$app['produtoService'] = function () use ($em){
    $produto = new Produto();
    $mapper = new ProdutoMapper($em);

    return new ProdutoService($produto, $mapper);
};

$app->get('/', function () use ($app){
    return $app['twig']->render('index.twig', []);
});


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

$app->run();