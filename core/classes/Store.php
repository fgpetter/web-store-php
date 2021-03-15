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
  public static function redirect($rota = 'inicio') {
    
    // TODO -  processar todas as flash messages aqui também
    header("Location: ${BASE_URL}?a={$rota}");
    
  }


}