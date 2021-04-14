<?php

namespace core\controllers;

use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

class MainController {

  /**
   * Display index page
   * 
   * @return View inicio
   */  
  public function index() {

    $dados = [];

    Store::Layout([
      'layouts/html_header',
      'layouts/header',
      'inicio',
      'layouts/footer',
      'layouts/html_footer'
    ], $dados);
  }


  /**
   * Display store catalog page
   * 
   * @return View loja
   */
  public function loja() {

    $produtos = new Produtos();

    $categoria = '';
    if( isset( $_GET['c'] ) && !empty( $_GET['c'] ) && $_GET['c'] != 'todos'){
      //sanitize data
      $rawData = $_GET['c'];
      $categoria = preg_replace('/[^A-Za-z0-9\-]/', '', $rawData);
    }

    $listaProdutos = $produtos->listaProdutosAtivos( $categoria );    
    if( count( $listaProdutos  ) == 0 ) {
      $listaProdutos = 'Não existem produtos nessa busca';
    }

    $listaCategorias = $produtos->listaCategorias();

    $dados = [
      'listaProdutos' => $listaProdutos,
      'listaCategorias' => $listaCategorias,
    ];

    Store::Layout([
      'layouts/html_header',
      'layouts/header',
      'loja',
      'layouts/footer',
      'layouts/html_footer'
    ], $dados);
  }
  
  /**
   * Display login and sing-up page
   * 
   * @return View login
   */
  public function login() {

    if(Store::clienteLogado()) {
      Store::redirect();
      return;
    }

    $dados = [];
    
    Store::Layout([
      'layouts/html_header',
      'layouts/header',
      'login',
      'layouts/footer',
      'layouts/html_footer'
    ], $dados);
  }


  /**
   * Process sign-up form
   * 
   * @return View cadastro_sucesso | back with errors
   */
  public function criarCliente() {
    
    // Check if is logged
    if(Store::clienteLogado()) {
      Store::redirect();
      return;
    }

    // Check if is POST request
    if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
      Store::redirect();;
      return;
    }

    // Check if passwords match
    if( $_POST['password'] != $_POST['password_repeat'] ) {

      // TODO - retornar a tela de cadastro com os dados preenchidos
      $_SESSION['erro'] = 'As senhas não são iguais';
      $this->login();
      return;

    }

    // Check if email exists in DB
    $clientes = new Clientes();
    if( $clientes->verificaClienteRegistrado( $_POST['email'] ) ){
      // TODO - retornar a tela de cadastro com os dados preenchidos
      $_SESSION['erro'] = 'Email já cadastrado';
      $this->login();
      return;
    }

    
    // Sanitize data to create customer
    $purl = Store::criarHash();
    $sanitizeTel = ['-', '(', ')',' '];
    
    $parametros = [
      ':nome' => addslashes( $_POST['nome'] ),
      ':email' => strtolower( trim( $_POST['email'] ) ),
      ':senha' => password_hash( $_POST['password'],  PASSWORD_DEFAULT ),
      ':endereco' => addslashes( $_POST['endereco'] ),
      ':cidade' => addslashes( $_POST['cidade'] ),
      ':telefone' => addslashes( trim( str_replace( $sanitizeTel, '', $_POST['telefone'] ) ) ),
      ':purl' => $purl,
      ':ativo' => 0,
    ];
    
    // Create customer
    $clientes->cadastraCliente($parametros);    
    
    // create link purl
    $userUniqueLink = BASE_URL."?a=confirm-email&purl=".$purl;

    // Send confirmation e-mail
    $emailCliente = strtolower( $_POST['email'] ) ;
    $nomeCliente = ucwords( strtolower( $_POST['nome'] ) );

    $textMessage = "<h3>Olá {$nomeCliente}!</h3>
                    <p>Clique no link abaixo para confirmar seu e-mail<br>
                    <a style='font-size: 1.8em;' href='{$userUniqueLink}'>CONFIRMAR E-MAIL</a></p>
                    <p>Caso não consiga, copie e cole o link em seu navegador<br>
                    {$userUniqueLink}";

    $email = new EnviarEmail();
    if($email->enviarEmailConfirmNovoCliente($emailCliente, $nomeCliente, $userUniqueLink, $textMessage)){
      
      $dados = [
        'email' => $emailCliente,
      ];

      Store::Layout([
        'layouts/html_header',
        'layouts/header',
        'cadastro_sucesso',
        'layouts/footer',
        'layouts/html_footer'
      ], $dados);
      return;

    } else {
      $_SESSION['erro'] = 'Ocorreu um erro, tente novamente em alguns instantes.';
      $this->login();
    }
    
  }


  /**
   * E-mail validation process
   * 
   * @return View index | back with errors
   */
  public function confirmEmail() {
    
    // Check if is logged
    if(Store::clienteLogado()) {
      Store::redirect();
      return;
    }

    // Check if is a purl parameter
    if( !isset( $_GET['purl'] ) ) {
      Store::redirect();;
      return;
    }

    // Check if is a valid lenght purl
    $purl = $_GET['purl'];
    if( strlen( $purl ) != 32) {
      Store::redirect();;
      return;
    }

    $clientes = new Clientes();
    if( $clientes->validarEmail( $purl ) ){

      // TODO - refatorar para caso tenha itens no carrinho, retornar ao carrinho logado, caso não retorna ao index
      Store::redirect();

    } else {
      
      echo 'E-mail não foi validado';

    }

  }


  /**
   * Login process
   * 
   * @return View index | back with errors
   */
  public function logarCliente() {
    
    // Check if is logged
    if(Store::clienteLogado()) {
      Store::redirect();
      return;
    }

    // Check if is POST request
    if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
      Store::redirect();
      return;
    }

    // Sanitize data to create customer
    if(!isset( $_POST['email'] ) || !filter_var( trim( $_POST['email'] ), FILTER_VALIDATE_EMAIL ) || !isset( $_POST['password'] )){
      $_SESSION['erro'] = 'Ocorreu um erro, e-mail ou senha inválidos.';
      Store::redirect('login');
      return;
    }

    $email = strtolower( trim( $_POST['email'] ) );
    $senha = trim( $_POST['password'] );

    // Check data in DB
    $clientes = new Clientes();
    
    $resultados = $clientes->validarLogin( $email, $senha );
    
    if( $resultados ){
      
      $_SESSION['cliente'] = $resultados->id;
      $_SESSION['usuario'] = $resultados->email;
      $_SESSION['cliente_nome'] = $resultados->nome;
      Store::redirect();
      return;

    }

    $_SESSION['erro'] = 'Ocorreu um erro, e-mail ou senha inválidos.';
    Store::redirect('login');
    return;  
    
  }


  /**
   * Logout process
   * 
   * @return void
   */
  public function logout() {
    unset( $_SESSION['cliente'] );
    unset( $_SESSION['usuario'] );
    unset( $_SESSION['cliente_nome'] );
    Store::redirect();
    return;

  }

}