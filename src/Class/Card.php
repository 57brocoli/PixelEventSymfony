<?php

namespace App\Class;

class Card {
    public $titre;
    public $image;
    public $link;

    public function __construct($titre, $image, $link) {
        $this->titre = $titre;
        $this->image = $image;
        $this->link = $link;
    }
}