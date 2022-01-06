<?php

class Anagram
{

    private $possibilite = 1;
    private $mot;
    private $nbr;
    private $lettres = [];
    private $list_combi = [];


    function __construct($mot, $nbr)
    {
        $this->nbr = strlen($mot) - $nbr;
        $this->mot = $mot;
        for ($i = 0; $i < strlen($mot); $i++) {
            $this->lettres[] = $mot[$i];
        }
    }

    function get_lettres()
    {
        print_r($this->lettres);
    }

    function nbr_possibilite()
    {
        $i = 1;
        while ($i <= $this->nbr) {
            $this->possibilite *= $i;
            $i++;
        }
    }

    function combi($mot)
    {
        $letters = [];
        for ($a = 0; $a < strlen($mot) - 1; $a++) {
            $letters[] = $mot[$a];
        }
        foreach ($letters as $key => $lettre) {
            $newMot = $lettre;
            for ($i = $this->nbr - 1; $i >= 0; $i--) {
                if ($i != $key) {
                    $newMot .= $mot[$i];
                }
            }
            $this->list_combi[] = $newMot;
        }
        if (count($this->list_combi) < $this->possibilite) {
            $this->combi($newMot);
        }
    }

    // function get_list_combi()
    // {
    //     $result = array_unique($this->list_combi);
    //     foreach ($result as $key => $value) {
    //         echo $value . PHP_EOL;
    //     }
    // }

    function read_dictionary()
    {
        $fopen = fopen("anagram-dictionnaire.txt", 'r+');
        if ($fopen) {
            while (($line = fgets($fopen)) !== false) {
                $dict = trim($line);
                if ($this->nbr == strlen($dict)) {
                    $this->parse_word($dict);
                }
            }
        }
        fclose($fopen);
    }

    function parse_word($word)
    {
        $correspondance = "";
        $lettres = $this->lettres;
        for ($i = 0; $i < strlen($word); $i++) {
            foreach ($lettres as $key => $lettre) {
                if ($lettre == $word[$i]) {
                    $correspondance .= $lettre;
                    $lettres[$key] = "";
                }
            }
        }
        if (strlen($correspondance) == strlen($word) && $correspondance == $word && $this->mot != $word) {
            echo $correspondance . PHP_EOL;
        }
    }
}

$test = new Anagram($argv[1], $argv[2] ?? 0);
$test->nbr_possibilite();
$test->combi($argv[1]);
$test->read_dictionary();
