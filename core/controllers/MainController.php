<?php

namespace core\controllers;

use core\classes\Store;

class MainController {
  
  public function index() {

    $dados = [
      'titulo' => 'PHP Store',
    ];

    Store::Layout([
      'layouts/html_header',
      'layouts/header',
      'inicio',
      'layouts/footer',
      'layouts/html_footer'
    ], $dados);
  }

  public function loja() {

    $dados = [
      'titulo' => 'PHP Store',
    ];

    Store::Layout([
      'layouts/html_header',
      'layouts/header',
      'loja',
      'layouts/footer',
      'layouts/html_footer'
    ], $dados);
  }

  public function carrinho() {

    $dados = [
      'titulo' => 'PHP Store',
    ];

    Store::Layout([
      'layouts/html_header',
      'layouts/header',
      'carrinho',
      'layouts/footer',
      'layouts/html_footer'
    ], $dados);
  }
  
}