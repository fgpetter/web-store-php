<?php

namespace core\models;
use core\classes\Database;

class Produtos {

  public function listaProdutosAtivos( $categoria ) {
    
    $db = new Database();

    if( $categoria ) {

      $parametros = [
        ':categoria' => $categoria
      ];

      $produtos = $db->select( "SELECT * FROM produtos WHERE ativo = 1 AND deleted_at IS NULL AND categoria = :categoria", $parametros);

      return $produtos;

    }

    $produtos = $db->select( "SELECT * FROM produtos WHERE ativo = 1 AND deleted_at IS NULL");

    return $produtos;

  }

  public function listaCategorias() {

    $db = new Database();

    $categorias = $db->select( "SELECT DISTINCT categoria FROM produtos WHERE estoque > 0 AND ativo = 1" );

    return $categorias;
  }

}