<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Numeroteur
{
    private $em;

    public function __construct(EntityManagerInterface $EntityManagerInterface)
    {
        $this->em = $EntityManagerInterface;
    }

    public function reordonnerNumero(int $initialEntityId ,int $positionDepart, int $positionArrivee, array $fratrieDepart, array $fratrieArrivee)
    {
        // INSERTION = CREATION Scène et INSERTION dans épisode différent
        if ($positionDepart < 0 || $fratrieDepart != $fratrieArrivee)
        {
            // Pour faire une place, on INCREMENTE les numéros qui finiront derrière
            foreach($fratrieArrivee as $uneEntite) {
                $uneEntiteNumero = $uneEntite->getNumero();
                if ($uneEntite->getId() != $initialEntityId && $uneEntiteNumero >= $positionArrivee) {
                    $uneEntite->setNumero($uneEntiteNumero+1);
                    $this->em->persist($uneEntite);
                }
            }
        }
    
        // DESINSERTION = SUPPRESSION Scène et DESINSERTION de épisode d'origine
        if($positionArrivee < 0 || $fratrieDepart != $fratrieArrivee)
        {
            // Pour combler le vide, on DECREMENTE numéros scènes qui étaient postérieurs
            foreach($fratrieDepart as $uneEntite) {
                $uneEntiteNumero = $uneEntite->getNumero();
                if ($uneEntite->getId() != $initialEntityId && $uneEntiteNumero > $positionDepart) {
                    $uneEntite->setNumero($uneEntiteNumero-1);
                    $this->em->persist($uneEntite);
                }
            }
        }
    
        // CHANGEMENT POSITION = dans le même épisode
        if ($fratrieDepart == $fratrieArrivee)
        {
            // Si la position avance, on recule les entités égales et postérieurs
            if ($positionArrivee < $positionDepart) {
                foreach($fratrieDepart as $uneEntite) {
                    $uneEntiteNumero = $uneEntite->getNumero();
                    if ($uneEntite->getId() != $initialEntityId && $uneEntiteNumero >= $positionArrivee && $uneEntiteNumero < $positionDepart) {
                        $uneEntite->setNumero($uneEntiteNumero+1);
                        $this->em->persist($uneEntite);
                    }
                }
            // Si la position récule, on avance scènes égales et antérieurs
            } elseif ($positionArrivee > $positionDepart) {
                foreach($fratrieDepart as $uneEntite) {
                    $uneEntiteNumero = $uneEntite->getNumero();
                    if ($uneEntite->getId() != $initialEntityId && $uneEntiteNumero <= $positionArrivee && $uneEntiteNumero > $positionDepart) {
                        $uneEntite->setNumero($uneEntiteNumero-1);
                        $this->em->persist($uneEntite);
                    }
                }
            }
        }

        $this->em->flush();
    }
}