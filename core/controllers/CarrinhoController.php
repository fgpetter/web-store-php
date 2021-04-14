<?php
namespace core\controllers;

use core\classes\Store;

class CarrinhoController {  

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

  public function adicionarCarrinho() {

    $idProduto  = $_GET['idProduto'];

    $carrinho = [];

    if( isset( $_SESSION['carrinho'] ) ) {

      $carrinho = $_SESSION['carrinho'];

    }

    if( key_exists( $idProduto, $carrinho )){

      $carrinho[$idProduto] ++;

    } else {

      $carrinho[$idProduto] = 1;

    }

    $_SESSION['carrinho'] = $carrinho;

    $totalProdutos = 0;
    
    foreach ($carrinho as $item) {

      $totalProdutos += $item;

    }

    if ($totalProdutos == 0) {
      unset($_SESSION['totalProdutos']);

    } else {
      $_SESSION['totalProdutos'] = $totalProdutos;

    }
    echo $totalProdutos;

  }


}