<?php
    //classe gerada pelo framewok Prodigio()
    //@author Maickon Rangel
    //@version 0.1

    class Maickon extends Prodigio_DB{
		private $nome;
		private $idade;
		private $sobrenome;

        public function __construct($nome= "",$idade= "",$sobrenome= ""){
             $this->nome = $nome;
		     $this->idade = $idade;
		     $this->sobrenome = $sobrenome;
		}

        public function getNome(){
            return $this->nome;
        }
    

        public function setNome($nome){
            $this->nome = $nome;
        }
    

        public function getIdade(){
            return $this->idade;
        }
    

        public function setIdade($idade){
            $this->idade = $idade;
        }
    

        public function getSobrenome(){
            return $this->sobrenome;
        }
    

        public function setSobrenome($sobrenome){
            $this->sobrenome = $sobrenome;
        }
    
	}


    $c = new Maickon();