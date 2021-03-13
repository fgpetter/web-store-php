<div class="container">
  <div class="row mt-5">
    <div class="col-12 col-md-6">
      <div class="card my-3 mx-auto" style="max-width: 400px;">        
        <div class="card-body">
          <h5 class="card-title mb-3">Já é cliente? Faça login para acessar</h5>
          <form>
            <div class="mb-3">
              <input name="email" type="email" class="form-control" id="" placeholder="Seu e-mail" required>
            </div>
            <div class="mb-3">
              <input name="password" type="password" class="form-control" id="" placeholder="Sua senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
          </form>            
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="card my-3 mx-auto" style="max-width: 400px;">        
        <div class="card-body">
          <h5 class="card-title mb-3">Ainda não é cliente? Cadastre-se</h5>

          <?php if(isset($_SESSION['erro'])): ?>
            <div class="alert alert-danger" role="alert"><?= $_SESSION['erro']; ?></div>
          <?php unset($_SESSION['erro']); endif; ?>

          <form action="?a=criar-cliente" method="POST">
            <div class="mb-3">
              <input name="nome" type="text" class="form-control" id="" placeholder="Seu mome" required>
            </div>
            <div class="mb-3">
              <input name="email" type="email" class="form-control" id="" placeholder="Seu e-mail" required>
            </div>
            <div class="mb-3">
              <input name="password" type="password" class="form-control" id="" placeholder="Sua senha" required>
            </div>
            <div class="mb-3">
              <input name="password_repeat" type="password" class="form-control" id="" placeholder="Repita a senha" required>
            </div>
            <div class="mb-3">
              <input name="endereco" type="text" class="form-control" id="" placeholder="Endereço completo" required>
            </div>
            <div class="mb-3">
              <input name="cidade" type="text" class="form-control" id="" placeholder="Cidade" required>
            </div>
            <div class="mb-3">
              <input name="telefone" type="tel" class="form-control" id="" placeholder="Telefone" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>