<?php

class Classe extends SimpleOrm {
    public $id;
    public $nom;
}

function recuperer_une_classe(int $id_classe): object {
    return Classe::retrieveByField('id', $id_classe, SimpleOrm::FETCH_ONE);
}