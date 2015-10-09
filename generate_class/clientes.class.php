<?php
    //classe gerada pelo framewok Prodigio()
    //@author Maickon Rangel
    //@version 0.1

    class Clientes{
		private $nome;
		private $nascimento;
		private $idade;
		private $contato;

        public function __construct($nome= "",$nascimento= "",$idade= "",$contato= ""){
             $this->nome = $nome;
		     $this->nascimento = $nascimento;
		     $this->idade = $idade;
		     $this->contato = $contato;
		}

        public function getNome(){
            return $this->nome;
        }
    

        public function setNome($nome){
            $this->nome = $nome;
        }
    

        public function getNascimento(){
            return $this->nascimento;
        }
    

        public function setNascimento($nascimento){
            $this->nascimento = $nascimento;
        }
    

        public function getIdade(){
            return $this->idade;
        }
    

        public function setIdade($idade){
            $this->idade = $idade;
        }
    

        public function getContato(){
            return $this->contato;
        }
    

        public function setContato($contato){
            $this->contato = $contato;
        }
    
	}


    $c = new Clientes();