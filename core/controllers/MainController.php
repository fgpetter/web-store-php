<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\Store;

class MainController {

  /**
   * Display index page.
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
   * @param
   * @return
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
    $db = new Database();
    $params = [
      ':email' => strtolower( trim( $_POST['email'] ) ),
    ];
    $resultados = $db->select( "SELECT email FROM clientes WHERE email = :email", $params );

    if( count( $resultados ) > 0 ) {
      
      $_SESSION['erro'] = 'Email já cadastrado';
      $this->login();
      return;

      // TODO - retornar a tela de cadastro com os dados preenchidos
      
    }
    
    // Create customer in DB
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

    $db->insert("INSERT INTO clientes VALUES(0, :nome, :email, :senha, :endereco, :cidade, :telefone, :purl, :ativo, NOW(), NOW(), NULL)", $params);
    
    // create link purl
    $userUniqueLink = "http://localhost/web-store-php/public/?a=confirm-email&purl=".$purl


    

    /*
    [nome]
    [email]
    [password]
    [password_repeat]
    [endereco]
    [cidade]
    [telefone]
     */
  }

}