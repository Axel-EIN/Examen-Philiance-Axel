<?php
// 1. Connexion à la BDD
include __DIR__ . '/connexion_bdd.php';

// 2. Inclusion des modèles et fonctions
include __DIR__ . '/modeles.php';
include_once __DIR__ . '/fonctions.php';

// 3.A MODE UPDATE
if (!empty($_POST['Modifier']) && !empty($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{
    // Je retrouve la saison a éditer via un retrive
    $saison_a_editer = Saisons::retrieveByPK($_GET['id']);

    // J'édites ses champs++
    $saison_a_editer->numero = $_POST['saison_numero'];
    $saison_a_editer->titre = $_POST['saison_titre'];
    $saison_a_editer->image = $_POST['saison_image'];
    $saison_a_editer->couleur = $_POST['saison_couleur'];

    // Je sauvegarde
    $saison_a_editer->save();

    // Je prépare la notifification
    $alert_message = 'La Saison a bien été modifiée';
}

// 3.B MODE CREATE
if (!empty($_POST['Créer']))
{
    // Je crée une nouvelle instance de la classe saison
    $saison_cree = new Saisons;

    // Je remplis les champs
    $saison_cree->numero = $_POST['saison_numero'];
    $saison_cree->titre = $_POST['saison_titre'];
    $saison_cree->image = $_POST['saison_image'];
    $saison_cree->couleur = $_POST['saison_couleur'];

    // Je sauvegarde
    $saison_cree->save();

    // Je prépare la notifification
    $alert_message = 'La Saison a bien été crée';
}

// 3.C MODE AFFICHAGE
$saisons = Saisons::all();
if (!empty($_GET['numero']) && is_numeric($_GET['numero']) && $_GET['numero'] > 0)
{
    $mode = 'Modifier';
    foreach($saisons as $cle => $valeur)
        if ($saisons[$cle]->numero == $_GET['numero'])
            $saison_choisie = $saisons[$cle];

    $id_saison = $saison_choisie->id;
    $numero_saison = $saison_choisie->numero;
    $value_numero = $saison_choisie->numero;
    $value_titre = $saison_choisie->titre;
    $value_image = $saison_choisie->image;
    $value_couleur = $saison_choisie->couleur;
}
elseif (!empty($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{
    $mode = 'Modifier';
    foreach($saisons as $cle => $valeur)
        if ($saisons[$cle]->id == $_GET['id'])
            $saison_choisie = $saisons[$cle];

    $id_saison = $saison_choisie->id;
    $numero_saison = $saison_choisie->numero;
    $value_numero = $saison_choisie->numero;
    $value_titre = $saison_choisie->titre;
    $value_image = $saison_choisie->image;
    $value_couleur = $saison_choisie->couleur;
}
else
{
    $numero_saison = 0;
    $mode = 'Créer';
    $value_numero = '';
    $value_titre = '';
    $value_image = '';
    $value_couleur = '';
}

$title_html = $mode . ' une Saison | Panneau d\'Administration';

// 7. Lancement de l'Affichage avec le HTML à trous
include_once __DIR__ . './header.php';
include_once __DIR__ . './nav.php'; ?>

<!-- BREADCRUMBS -->
<div class="container-fluid bg-light">
    <nav class="container" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="admin.php">Index du Panneau d'Administration</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $mode; ?> une Saison</li>
        </ol>
    </nav>
</div>

<div class="container">
    <!-- MESSAGE ALERT -->
    <?php if(!empty($alert_message)): ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <strong><?= $alert_message; ?></strong> - <a href="admin.php">Revenir au Panneau d'Administration</a>
        </div>
    <?php endif; ?>
</div>

<section class="container my-5 d-flex justify-content-center">
    <form class="w-100 d-flex justify-content-center" action="admin_saison.php?mode=<?= $mode; if($mode == 'Modifier') echo '&id=' . $id_saison; ?>" method="post">
        <fieldset class="p-5 col-12">
            <legend><?= $mode; ?> une Saison :</legend>
            <label for="saison_numero">Numero :</label>
            <select name="saison_numero" id="saison_numero">
                <?php
                    $max = sizeof($saisons)+6;
                    for ($i = 1; $i < $max; $i++)
                    { ?>
                        <option value="<?= $i; ?>"
                            <?php foreach ($saisons as $cle => $valeur)
                                    if ($saisons[$cle]->numero == $i)
                                        if ($saisons[$cle]->numero == $numero_saison)
                                            echo 'selected';
                                        else
                                            echo 'disabled';
                            ?> ><?= $i; ?></option>
            <?php   } ?>
            </select><br/>
            <label for="saison_titre">Titre :</label><br/>
            <input class="form-control" type="text" id="saison_titre" name="saison_titre" maxlength="50" placeholder="50 caractères max..." value="<?= $value_titre; ?>"><br/>           
            <label for="saison_image">Image de la Saison :<br/><small class="text-muted font-italic">16/9 1200x720px conseillé</small></label><br/>
            <input class="form-control" type="text" id="saison_image" name="saison_image" placeholder="255 caractères max..." value="<?= $value_image; ?>"><br/>        
            <label for="saison_couleur">Couleur de fond :</label><br/>
            <input type="color" name="saison_couleur" id="saison_couleur" value="<?= $value_couleur; ?>"><br/>
            <div class="text-center">
                <input type="submit" name="<?= $mode; ?>" class="btn btn-primary m-3" value="<?= $mode; ?> la Saison">
            </div>
        </fieldset>
    </form>
</section>

<?php
include_once __DIR__ . './footer.php';