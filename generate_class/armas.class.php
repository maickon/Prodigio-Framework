
<?php
    //classe gerada pelo framewok Prodigio()
    //@author Maickon Rangel
    //@version 0.1

    class Armas{
		private $nome;
		private $preco;
		private $dano;
		private $critico;
		private $distancia;
		private $peso;
		private $tipo;

        public function __construct($nome= "",$preco= "",$dano= "",$critico= "",$distancia= "",$peso= "",$tipo= ""){
                $this->nome = $nome;
	     $this->preco = $preco;
	     $this->dano = $dano;
	     $this->critico = $critico;
	     $this->distancia = $distancia;
	     $this->peso = $peso;
	     $this->tipo = $tipo;
	}

        public function getNome(){
            return $this->nome;
        }


        public function setNome($nome){
            $this->nome = $nome;
        }


        public function getPreco(){
            return $this->preco;
        }


        public function setPreco($preco){
            $this->preco = $preco;
        }


        public function getDano(){
            return $this->dano;
        }


        public function setDano($dano){
            $this->dano = $dano;
        }


        public function getCritico(){
            return $this->critico;
        }


        public function setCritico($critico){
            $this->critico = $critico;
        }


        public function getDistancia(){
            return $this->distancia;
        }


        public function setDistancia($distancia){
            $this->distancia = $distancia;
        }


        public function getPeso(){
            return $this->peso;
        }


        public function setPeso($peso){
            $this->peso = $peso;
        }


        public function getTipo(){
            return $this->tipo;
        }


        public function setTipo($tipo){
            $this->tipo = $tipo;
        }

}


    $c = new Armas();