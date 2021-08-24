<?php
/**
 * Un modèle = une classe
 * qui donne la "forme" de la donnée
 * 
 * et qui "extends" SimpleOrm
 * (qui "utilise" SimpleOrm)
 */
class Scenes extends SimpleOrm {
	public $id;
	public $numero;
	public $num_episode;
	public $num_chapitre;
	public $num_saison;
	public $titre;
	public $temps;
    public $image;
    public $texte;
}

class Episodes extends SimpleOrm {
	public $id;
	public $numero;
	public $num_chapitre;
	public $num_saison;
	public $titre;
	public $resume;
    public $image;
}

class Chapitres extends SimpleOrm {
	public $id;
	public $numero;
	public $num_saison;
	public $titre;
	public $entete;
	public $citation;
    public $image;
	public $couleur;
	public $mj;
}

class Saisons extends SimpleOrm {
	public $id;
	public $numero;
	public $titre;
	public $entete;
    public $image;
	public $couleur;
}


