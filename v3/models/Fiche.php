<?php

class Fiche extends SimpleOrm {

	public $id;
	public $personnage_id;
	public $xp_creation;
	public $avantages;
    public $desavantages;
	public $constitution;
	public $volonte;
	public $reflexes;
	public $intuition;
	public $agilite;
	public $intelligence;
	public $force;
	public $perception;
	public $vide;

}

function recuperer_fiche_personnage(int $id_personnage) {

    $fiche_personnage = Fiche::retrieveByField('personnage_id', $id_personnage, SimpleOrm::FETCH_ONE);

    return $fiche_personnage;
}