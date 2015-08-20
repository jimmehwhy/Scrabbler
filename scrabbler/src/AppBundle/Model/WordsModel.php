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
        $this->letters = $letters;

        $chars = str_split($letters);

        $words = array();

        if(count($chars) < 9)
        $words = $this->combinations($chars);

        $words = $this->checkedWords($words);

        usort($words, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        $this->words = $words;

        return $this->words;
    }

    function combinations($letters, $words = null, $thisWord = null){
        if(count($letters) == 0){
            return $words;
        }

        if(empty($thisWord)){
            $thisWord = '';
        }

//        foreach($letters as $l_index => $a_letter){
//            $new_letters = $letters;
//
//            unset($new_letters[$l_index]);
//            $new_letters = array_values($new_letters);
//
//            if(empty($words)){
//                $thisWord = $a_letter;
//            } else {
//                $thisWord = $thisWord . $a_letter;
//            }
//
//            $words[] = $thisWord;
//
//
//            $words = $this->combinations($new_letters, $words, $thisWord);
//
//            if(empty($words)){
//                $thisWord = '';
//            } else {
//                $thisWord = substr($thisWord, 0, count($thisWord));
//            }
//
//        }



        if(empty($words)){
            //first set of words are letters
            foreach($letters as $l_index => $a_letter){
                $new_letters = $letters;

                unset($new_letters[$l_index]);
                $new_letters = array_values($new_letters);

                $thisWord = $a_letter;
                $words[] = $thisWord;
                $words = $this->combinations($new_letters, $words, $thisWord);
                $thisWord = '';
            }

            //after creating all words, for each letter, return them
            return $words;
        }
        else {
            foreach ($letters as $l_index => $a_letter) {
                $new_letters = $letters;

                unset($new_letters[$l_index]);
                $new_letters = array_values($new_letters);
                $oldWord = $thisWord;
                $thisWord = $thisWord . $a_letter;
                $words[] = $thisWord;

                $words = $this->combinations($new_letters, $words, $thisWord);
                $thisWord = $oldWord;
            }
        }

        return $words;
    }

    //shit search. algorythm needs to be optimised
    //TODO binary search
    private function checkedWords($words){
        //check words in dictionary
        $checkedWords = array();
        $dict = [];

        $file = fopen('C:\wamp\www\Scrabbler\scrabbler\src\AppBundle\Resources\Dictionary\dictionary', 'r');
        $fread = fread($file, filesize('C:\wamp\www\Scrabbler\scrabbler\src\AppBundle\Resources\Dictionary\dictionary'));

        $split = explode("\n", $fread);
        $array[] = null;

        foreach ($split as $string)
        {
            $string = str_replace(array("\r", "\n"), '', $string);
            array_push($dict,$string);
        }

        foreach($words as $word){
            if(strlen($word) > 2) {
                if (in_array($word, $dict)) {
                    $checkedWords[] = $word;
                }
            }

        }

        return $checkedWords;
    }
}