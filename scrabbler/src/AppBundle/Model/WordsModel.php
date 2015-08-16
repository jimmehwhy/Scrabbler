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

        $chars = str_split($letters);
        //var_dump($chars);

        $this->words = $this->permutations($chars, count($chars) -1);
        //var_dump($this->words);

        return $this->words;
    }

    function permutations($chars, $size, $combinations = array()){
        if(empty($combinations)){
            $combinations = $chars;
        }

        if($size == 1){
            return $combinations;
        }

        $new_combinations = array();

        # loop through existing combinations and character set to create strings
        foreach ($combinations as $combination) {
            foreach ($chars as $char) {
                //TODO needs a braking mechanism
                $new_combinations[] = $combination . $char;
            }
        }

        # call same function again for the next iteration
        return $this->permutations($chars, $size - 1, $new_combinations);
    }
}