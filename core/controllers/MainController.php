<?php

namespace core\controllers;

use core\classes\Store;

class MainController {
  
  public function index() {

    $dados = [
      'titulo' => 'PHP Store',
    ];

    Store::Layout([
      'layouts/header',
      'pagina-inicial',
      'layouts/footer'
    ], $dados);
  }
  
}