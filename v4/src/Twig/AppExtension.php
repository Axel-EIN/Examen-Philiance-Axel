<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('stylise', [$this, 'titreStylise']),
        ];
    }

    public function titreStylise($titre)
    {
        // Cette fonction prend une chaîne de caractère et la stylise en ajoutant des balises span
        // qui vont réduire la taille des determinants et des mot de liaisons
    
        $search = ' à ';
        $replace = '<span class=petit> &nbsp;à&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = 'Le ';
        $replace = '<span class=petit>Le&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = ' le ';
        $replace = '<span class=petit> &nbsp;le&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = 'La ';
        $replace = '<span class=petit>La&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = ' la ';
        $replace = '<span class=petit> &nbsp;la&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = 'Les ';
        $replace = '<span class=petit>Les&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = ' les ';
        $replace = '<span class=petit> &nbsp;les&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = 'Du ';
        $replace = '<span class=petit>Du&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = ' du ';
        $replace = '<span class=petit> &nbsp;du&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = 'De ';
        $replace = '<span class=petit>De&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = ' de ';
        $replace = '<span class=petit> &nbsp;de&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = 'Des ';
        $replace = '<span class=petit>Des&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = ' des ';
        $replace = '<span class=petit> &nbsp;des&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = 'Dans ';
        $replace = '<span class=petit>Dans&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = ' dans ';
        $replace = '<span class=petit> &nbsp;dans&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);
    
        $search = 'l\'';
        $replace = '<span class=petit>l\'&nbsp; </span>';
        $titre = str_replace($search,$replace,$titre);

        $search = 'L\'';
        $replace = '<span class=petit>L\'</span>';
        $titre = str_replace($search,$replace,$titre);

        $search = ' et ';
        $replace = ' <span class=petit>et</span> ';
        $titre = str_replace($search,$replace,$titre);

        $search = ' son ';
        $replace = ' <span class=petit>son</span> ';
        $titre = str_replace($search,$replace,$titre);
    
        return $titre;
    }
}