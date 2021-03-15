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
   * Process email validation
   * 
   * @param string $purl
   * @return bool
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


  /**
   * Process login
   * 
   * @param string $email
   * @param string $senha 
   * @return object
   */
  public function validarLogin( $email, $senha ) {

    $parametros = [
      ':email' => $email
    ];

    $db = new Database();
    $resultados = $db->select( "SELECT * FROM clientes WHERE email = :email AND ativo = 1 AND deleted_at IS NULL", $parametros );

    if( count( $resultados ) != 1 ) {
      return false;
    }
    $usuario = $resultados[0];

    if( !password_verify( $senha, $usuario->senha ) ) {
      return false;
    }

    return $usuario;

  }



}