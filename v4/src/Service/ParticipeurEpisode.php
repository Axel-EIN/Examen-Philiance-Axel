<?php
namespace App\Service;

use App\Entity\Episode;
use App\Repository\PersonnageRepository;

class ParticipeurEpisode
{
    private $persoRepo;

    public function __construct(PersonnageRepository $personnageRepository)
    {
        $this->persoRepo = $personnageRepository;
    }

    public function personnagesEpisodes(Episode $episode)
    {
        $episode_participations = [];
        $episode_personnages_id = [];
        foreach($episode->getScenes() as $une_scene) {
            foreach($une_scene->getParticipations() as $une_participation) {
                if ($une_participation->getEstPj()) {
                    $episode_participations[] = $une_participation;
                    $episode_personnages_id[] = $une_participation->getPersonnage()->getId();
                }
            }
        }

        $episode_personnages_id = array_unique($episode_personnages_id);
        $compteur = 0;
        $episode_personnages = [];
        foreach($episode_personnages_id as $un_personnage_id) {
            $compteurXp = 0;
            $estMort = 0;
            foreach($episode_participations as $une_participation) {
                if ($une_participation->getPersonnage()->getId() == $un_personnage_id)
                {
                    $compteurXp = $compteurXp + $une_participation->getXpGagne();
                    if ($une_participation->getEstMort() == true)
                        $estMort = 1;
                }
            }
            $episode_personnages[$compteur]['personnageId'] = $un_personnage_id;
            $episode_personnages[$compteur]['prenom'] = $this->persoRepo->find($un_personnage_id)->getPrenom();
            $episode_personnages[$compteur]['xp'] = $compteurXp;
            $episode_personnages[$compteur]['estMort'] = $estMort;
            $episode_personnages[$compteur]['joueurId'] = $this->persoRepo->find($un_personnage_id)->getJoueur()->getId();
            $compteur++;
        }

        usort($episode_personnages, function ($a, $b) {
            return strcmp($a['xp'], $b['xp']);
        } );

        return array_reverse($episode_personnages);
    }
}