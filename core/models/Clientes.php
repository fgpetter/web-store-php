<?php

namespace core\models;

use core\classes\Database;

class Clientes {

  /**
   * Check email in database
   * 
   * @param string $email
   * @return bool
   */
  public function verificaClienteRegistrado($email) {
    
    $db = new Database();
    $params = [
      ':email' => strtolower( trim( $email ) ),
    ];
    $resultados = $db->select( "SELECT email FROM clientes WHERE email = :email", $params );

    if( count( $resultados ) > 0 ) {
      return true;
    }

    return false;
  }

  /**
   * Insert new customer in database
   * 
   * @param array $params
   * @return void
   */
  public function cadastraCliente($params) {

    $db = new Database();
    $db->insert("INSERT INTO clientes VALUES(0, :nome, :email, :senha, :endereco, :cidade, :telefone, :purl, :ativo, NOW(), NOW(), NULL)", $params);
    
  }

}