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
    $db->insert( "INSERT INTO clientes VALUES(0, :nome, :email, :senha, :endereco, :cidade, :telefone, :purl, :ativo, NOW(), NOW(), NULL)", $params );
    
  }


  /**
   * 
   */
  public function validarEmail($purl) {

    $parametros = [
      ':purl' => $purl,
    ];
    
    // check if purl exists and return cliente data
    $db = new Database();
    $resultados = $db->select( "SELECT * FROM clientes WHERE purl = :purl", $parametros );

    if( count( $resultados ) != 1 ) {
      return false;
    }
    
    $idCliente = $resultados[0]->id;

    $parametros = [
      ':id' => $idCliente,
    ];

    $db->update( "UPDATE clientes SET purl = null, ativo = 1, updated_at = NOW() WHERE id = :id", $parametros );

    return true;

    

  }

}