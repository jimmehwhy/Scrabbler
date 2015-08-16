<?php
/**
 * Created by PhpStorm.
 * User: jimmehWhy
 * Date: 16/08/2015
 * Time: 19:54
 */
namespace AppBundle\Model;

class WordsModel {

    private $letters;
    private $words;

    public function __construct__(){
        $this->letters = "";
        $this->words = array();
    }

    public function getWords($letters){
        //var_dump("In model");
        $this->letters = $letters;

        $this->words = array('and', 'an', 'am', 'dam', 'mad');

        return $this->words;
    }
}