<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;

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

    $dados = [];

    Store::Layout([
      'layouts/html_header',
      'layouts/header',
      'loja',
      'layouts/footer',
      'layouts/html_footer'
    ], $dados);
  }


  /**
   * Display cart page
   * 
   * @return View carrinho
  */
  public function carrinho() {

    $dados = [];

    Store::Layout([
      'layouts/html_header',
      'layouts/header',
      'carrinho',
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
      $this->index();
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
      $this->index();
      return;
    }

    // Check if is POST request
    if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
      $this->index();
      return;
    }

    // Check if is passwords match
    if( $_POST['password'] != $_POST['password_repeat'] ) {

      $_SESSION['erro'] = 'As senhas não são iguais';
      $this->login();
      return;

      // TODO - retornar a tela de cadastro com os dados preenchidos
    }

    // Check if email exists in DB
    $clientes = new Clientes();
    if( $clientes->verificaClienteRegistrado( $_POST['email'] ) ){
      $_SESSION['erro'] = 'Email já cadastrado';
      $this->login();
      return;
      // TODO - retornar a tela de cadastro com os dados preenchidos
    }

    
    // Sanitize data to create customer
    $purl = Store::criarHash();
    $sanitizeTel = ['-', '(', ')',' '];
    
    $params = [
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
    $clientes->cadastraCliente($params);    
    
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
      $this->index();
      return;
    }

    // Check if is a purl parameter
    if( !isset( $_GET['purl'] ) ) {
      $this->index();
      return;
    }

    // Check if is a valid lenght purl
    $purl = $_GET['purl'];
    if( strlen( $purl ) != 32) {
      $this->index();
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

}