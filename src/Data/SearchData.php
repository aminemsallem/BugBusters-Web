<?php


namespace App\Data;


use App\Entity\Categorie;

class SearchData
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Categorie[]
     */
    public $categories = [];


}