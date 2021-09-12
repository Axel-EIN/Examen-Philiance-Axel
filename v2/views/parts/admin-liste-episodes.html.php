<?php

function tableau_admin_liste_episodes() {
    if ($saisons === NULL)
        echo "Désolé, il n\'a aucune saison disponible!";
    else {
         { ?>
?>
    

<?php }
} ?>

            <?php
                    
                    $saisons_bis = $saisons;
                        <tr><th class="text-center bg-danger text-light display-4" colspan="7">Saison n°<?= $saison->numero; ?></th></tr>

                    <?php
                        $chapitres_saison = Chapitre::retrieveByField('id_saison', $saison->id, SimpleOrm::FETCH_MANY);
                        if ($chapitres_saison === NULL) {
                            $erreurs['chapitre'] = "Désolé, il n\'y a aucun chapitre disponible pour la saison n°" . $saison->numero;
                            echo '<tr><td colspan=7>' . $erreurs['chapitre'] . '</td></tr>';
                        } else {
                            foreach ($chapitres_saison as $un_chapitre_saison) { ?>
                        <tr><th class="text-center bg-light" colspan="9">Chapitre n°<?= $un_chapitre_saison->numero; ?></th></tr>
                            <?php
                                $episodes_chapitre = Episode::retrieveByField('id_chapitre', $un_chapitre_saison->id, SimpleOrm::FETCH_MANY);
                                if ($episodes_chapitre === NULL || empty($episodes_chapitre)) {
                                    $erreurs['episode'] = 'Désolé, il n\'y a aucun episode disponible pour ce chapitre';
                                    echo '<tr class="text-center text-muted"><td colspan=7>' . $erreurs['episode'] . '</td></tr>';
                                } else {
                                    foreach ($episodes_chapitre as $un_episode_chapitre) { ?>

                                <?php
                                    }
                                }
                            }
                        }
                    }
                }
            ?>
            </table>