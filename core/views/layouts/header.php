<?php use core\classes\Store; ?>

<nav class="navbar navbar-expand-lg navbar-dark navegacao">
  <div class="container-fluid container-sm">
    <a class="navbar-brand" href="?a=inicio">PHP Store</a>
    <button class="navbar-toggler ms-auto mx-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse me-4" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
        <li class="nav-item">
          <a class="nav-link" href="?a=inicio">Home</a>    
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?a=loja">Loja</a>    
        </li>        
      </ul>
    </div>
    <div class="">
      <a class="me-2"  href="?a=carrinho"><i class="fas fa-shopping-cart"></i></a>
        <?php if( Store::clienteLogado() ): ?>
          <a class="me-2" href="?a=minha-conta"><i class="far fa-user-circle"></i></a>    
          <a class="me-0" href="?a=logout"><i class="fas fa-sign-out-alt"></i></a>    
        <?php else: ?>
              <a class="ms-0 login" href="?a=login">Login</a> | 
              <a class="me-0 login" href="?a=login">Cadastro</a>
            </li>
        <?php endif; ?>
    </div>
  </div>
</nav>