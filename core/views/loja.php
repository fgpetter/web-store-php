<div class="container mb-5">
  <div class="row">
    <div class="col-12">
      <h1 class="h1 my-5">Loja</h1>              
    </div>
  </div>
  <div class="row">
    <!-- Barra lateral de busca -->
    <aside class="col-12 col-sm-3">

      <div class="list-group">
        <a class="list-group-item list-group-item-action active fs-5">SELECIONE</a>
        <a class="list-group-item list-group-item-action" href="?a=loja&c=todos">Ver todos</a>
        <?php foreach( $listaCategorias as $categoria ): ?>
        <a class="list-group-item list-group-item-action" href="?a=loja&c=<?= $categoria->categoria ?>"><?= ucwords( $categoria->categoria ) ?></a>
        <?php endforeach; ?>
      </ul>
    
    </aside>
    <!-- Sessão de lista de itens -->
    <!-- TODO criar opção espiar item com modal e ajax -->
    <section class="col-12 col-sm-9">
      <ul class="row list-unstyled">
      <?php if( is_array( $listaProdutos ) ): ?>
      <?php foreach( $listaProdutos as $produto ): ?>
        <li class="col-12 col-sm-6 col-xl-4 lis">

          <div class="card mb-5 border-0" style="max-width: 18rem;">
            <img src="assets/images/produtos/<?=$produto->imagem?>" class="img-fluid" alt="<?= $produto->nome ?>">
            <div class="card-body text-center">
              <h4 class="card-title">R$ <?= $produto->valor ?></h5>
              <h5 class="card-subtitle mb-2 text-muted"><?= $produto->nome ?></h6>
              <a href="" class="btn btn-sm btn-outline-primary">COMPRAR</a>
            </div>
          </div>
          
        </li>
        <?php endforeach; ?>
        <?php else: ?>
          <h4><?= $listaProdutos ?></h4>
          <div class="col-2"><a href="?a=loja" class="btn btn-sm btn-outline-primary">RETORNAR</a></div>
          
        <?php endif; ?>
      </ul>
    </section>
  </div>
</div>