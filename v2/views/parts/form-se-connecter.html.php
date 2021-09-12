<!-- FORMULAIRE SE CONNECTER -->
<form method="post" action="<?= route('se-connecter-handler') ?>">

  <div class="form-group">
    <label for="identifiant" class="col-form-label">Identifiant:</label>
    <input type="text" class="form-control" id="identifiant" name='identifiant' autofocus required placeholder="Entrez votre identifiant...">
  </div>

  <div class="form-group">
    <label for="mdp" class="col-form-label">Mot de passe:</label>
    <input type="mdp" class="form-control" id="mdp" name="mdp" required placeholder="Entrez votre mot de passe...">
  </div>

  <div class="form-group text-center">
    <input type="checkbox" class="form-check-input" name="rester_connecte" id="rester_connecte" value="true">
      &nbsp;&nbsp;Rester connecté
  </div>

  <div class="form-group text-center">
    <input class="btn btn-primary" type="submit" name="connexion" value="Se connecter">
  </div>

</form>