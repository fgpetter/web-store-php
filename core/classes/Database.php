<?php

namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database {

  private $ligacao;

  private function ligar() {
    $this->ligacao = new PDO(
      'mysql:host='.MYSQL_SERVER.';'.
      'dbname='.MYSQL_DATABASE.';'.
      'charset='.MYSQL_CHARSET,
      MYSQL_USER,
      MYSQL_PASS,
      array(PDO::ATTR_PERSISTENT => true)
    );
    
    $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }

  private function desligar() {

    $this->ligacao = null;

  }

    /**
     * SELECT Query helper
     * @param mixed $sql
     * @param mixed|null $parametros
     * @return string
     * @throws Exception
     */
  public function select($sql, $parametros = null) {

    // allow only select queries
    if(!preg_match("/^SELECT/i", $sql)){
      throw new Exception('Erro de banco de dados - Não é uma instrução SELECT');
    }
    
    $this->ligar();

    $resultados = null;

    try {
      
      if( !empty( $parametros ) ) {
        $executar = $this->ligacao->prepare( $sql );
        $executar->execute( $parametros );
        $resultados = $executar->fetchAll(PDO::FETCH_CLASS);

      } else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
        $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
      }
      
    } catch (PDOException $e) {
      return $e->getMessage();
    }

    $this->desligar();

    return $resultados;
  }


  /**
   * INSERT Query helper
   * 
   * @param mixed $sql
   * @param mixed|null $parametros
   * @return void
   */
  public function insert($sql, $parametros = null) {

    // allow only INSERT queries
    if(!preg_match("/^INSERT/i", $sql)){
      throw new Exception('Erro de banco de dados - Não é uma instrução INSERT');
    }
    
    $this->ligar();

    try {
      
      if(!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);

      } else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
      }
      
    } catch (PDOException $e) {
      
      return;
    }

    $this->desligar();
  }


  /**
   * UPDATE Query helper
   * 
   * @param mixed $sql
   * @param mixed|null $parametros
   * @return void
   */
  public function update($sql, $parametros = null) {

    // allow only UPDATE queries
    if(!preg_match("/^UPDATE/i", $sql)){
      throw new Exception('Erro de banco de dados - Não é uma instrução UPDATE');
    }
    
    $this->ligar();

    try {
      
      if(!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);

      } else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
      }
      
    } catch (PDOException $e) {
      
      return;
    }

    $this->desligar();
  }

  
  /**
   * DELETE Query helper
   * 
   * @param mixed $sql
   * @param mixed|null $parametros
   * @return void
   */
  public function delete($sql, $parametros = null) {

    // allow only DELETE queries
    if(!preg_match("/^DELETE/i", $sql)){
      throw new Exception('Erro de banco de dados - Não é uma instrução DELETE');
    }
    
    $this->ligar();

    try {
      
      if(!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);

      } else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
      }
      
    } catch (PDOException $e) {
      
      return;
    }

    $this->desligar();
  }

    
  /**
   * STATEMENT Query helper
   * Use for SQL commands eg. TRUNCATE, DROP etc.
   * 
   * @param mixed $sql
   * @param mixed|null $parametros
   * @return void
   */  
  public function statement($sql, $parametros = null) {

    // allow only other statement queries
    if(preg_match("/^(DELETE|INSERT|UPDATE)/i", $sql)){
      throw new Exception('Erro de banco de dados - Instrução inválida');
    }
    
    $this->ligar();

    try {
      
      if(!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);

      } else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
      }
      
    } catch (PDOException $e) {
      
      return;
    }

    $this->desligar();
  }


}