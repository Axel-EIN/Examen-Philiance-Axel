<?php

class Ecole extends SimpleOrm {
    public $id;
    public $nom;
    public $classe_id;
    public $technique1_nom;
    public $technique1_desc;
    public $technique2_nom;
    public $technique2_desc;
    public $technique3_nom;
    public $technique3_desc;
    public $technique4_nom;
    public $technique4_desc;
    public $technique5_nom;
    public $technique5_desc;
}

function recuperer_une_ecole(int $id_ecole): object {
    return Ecole::retrieveByField('id', $id_ecole, SimpleOrm::FETCH_ONE);
}