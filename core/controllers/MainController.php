<?php

namespace core\controllers;

use core\classes\Functions;

class MainController {
  
  public function index() {

    $dados = [
      'titulo' => 'Esse é o título',
      'clientes' => ['João', 'José', 'Maria', 'Carlos']
    ];

    Functions::Layout([
      'layouts/header',
      'pagina_inicial',
      'layouts/footer'
    ], $dados);
  }
}