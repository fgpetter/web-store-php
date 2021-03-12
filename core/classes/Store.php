<?php

namespace core\classes;

use Exception;

class Store {

  /**
   * Construct template view
   * @params $estruturas array
   * @params $dados array
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
   * @retunr bool
   */
  
  public static function clienteLogado() {
    
    return ( isset( $_SESSION['cliente'] ) );
  }

}