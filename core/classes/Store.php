<?php

namespace core\classes;

use Exception;

class Store {

  /**
   * Construct template view
   * @param $estruturas array
   * @param $dados array
   */  
  public static function Layout( $estruturas, $dados = null ) {

    // check if is a valid array
    if(!is_array( $estruturas )) {

      throw new Exception('Coleção de dados inválida');
    }

    if(!empty( $dados ) && is_array( $dados )) {

      extract( $dados );
    }

    foreach( $estruturas as $estrutura ) {

      include( "../core/views/$estrutura.php");
    }

  }


  /**
   * Check if is a custommer logged in session
   * @return bool
   */  
  public static function clienteLogado() {
    
    return ( isset( $_SESSION['cliente'] ) );
  }


  /**
   * Create a unique hash for e-mail validation
   * @return string
   */ 
  public static function criarHash() {

    return bin2hex( random_bytes( 16 ) );

  }


  /**
   * Process route redirection
   * @return view
   */ 
  public static function redirect( $rota = 'inicio' ) {
    
    // TODO -  processar todas as flash messages aqui também
    header("Location: ${BASE_URL}?a={$rota}");
    
  }

  public static function printData( $data ) {
    
    if( is_array($data) || is_object($data) ) {

      echo "<style>pre{background: #f4f4f4; border: 1px solid #ddd; border-left: 3px solid #3366f3; color: #555; page-break-inside: avoid; font-family: monospace; font-size: 15px; line-height: 1.6; margin-bottom: 1.6em; max-width: 100%; overflow: auto; padding: 1em 1.5em; display: block; word-wrap: break-word;}</style>";
      echo '<pre>';
      print_r( $data );

    } else {
      
      echo "<style>pre{background: #f4f4f4; border: 1px solid #ddd; border-left: 3px solid #3366f3; color: #555; page-break-inside: avoid; font-family: monospace; font-size: 15px; line-height: 1.6; margin-bottom: 1.6em; max-width: 100%; overflow: auto; padding: 1em 1.5em; display: block; word-wrap: break-word;}</style>";
      echo '<pre>';
      echo $data;
    }
    die();
  }


}