<?php
/**
 * TODO - Refatorar para nome:nome
 */
$routes = [
  'inicio' => 'mainController@index',
  'loja' => 'mainController@loja',
  'painel' => 'painelController@index',
  'carrinho' => 'mainController@carrinho',
  'login' => 'mainController@login',
  'criar-cliente' => 'mainController@criarCliente',
  'confirm-email' => 'mainController@confirmEmail',
];

$action = 'inicio';

/**
 * TODO - Refatorar para 'p' no lugar de 'a'
 * Check if have a GET request
 */

if(isset($_GET['a'])) {

  // check if get request is valid
  if(!key_exists($_GET['a'],$routes)) { 

    $action = 'inicio';

  } else {

    $action = $_GET['a'];
  }
}

/**
 * Split route string to controller and method
 */


// TODO - Avaliar a refatoração
// [$controlador, $metodo] = explode('@',$rotas[$acao]);
// $controlador= 'core\\controladores\\'.ucfirst($controlador);
$splitRouteString = explode('@', $routes[$action]);

//  variável $controler faz referencia para a classe através do namespace
// agora controller é a classe
$controller = '\\core\\controllers\\'.ucfirst($splitRouteString[0]);

// variável $method recebe o nome do método
$method = $splitRouteString[1];

// dessa forma controller pode ser chamada como uma classe e recebe ()
$ctr = new $controller();

// aqui equivale a mainController chamando o método index()
$ctr->$method();


/**
 * TODO - Avaliar a refatoração
 * [$controlador, $metodo] = explode('@',$rotas[$acao]);
 * $controlador= 'core\\controladores\\'.ucfirst($controlador);
 */