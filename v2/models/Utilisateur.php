<?php

class Utilisateur extends SimpleOrm {
    public $id;
    public $identifiant;
    public $email;
    public $mdp;
    public $prenom;
    public $role;
    public $image;
}