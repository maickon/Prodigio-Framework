<?php 

namespace App\Models;

use core\ActiveRecord;
use core\Validator;

Class Orders extends ActiveRecord {

    protected $table_name = 'orders';
    protected $foreign_relationship = [
        'client_id' => 'clients',
        'name_id' => 'names',
        'brand_id' => 'brands',
        'size_id' => 'sizes',
        'color_id' => 'colors'
    ];
    private $attributes = [
        'client_id',
        'name_id',
        'brand_id',
        'size_id',
        'color_id',
        'status',
        'shipping_type',
        'shipping_cost',
        'product_code',
        'quantity',
        'price',
        'photo',
        'created_at'
    ];

    public function getforeignRelationship() {
        return $this->foreign_relationship;
    }
    
    public function getAttributes() {
        return $this->attributes;
    }

    private function getRules() {
        return [
            'client_id'         => 'required|integer',
            'name_id'           => 'required|integer',
            'brand_id'          => 'required|integer',
            'size_id'           => 'required|integer',
            'color_id'          => 'required|integer',
            'status'            => 'required|maxLength:255',
            'shipping_type'     => 'required|maxLength:255',
            'shipping_cost'     => 'required|maxLength:255',
            'product_code'      => 'required|maxLength:255',
            'quantity'          => 'required|maxLength:255',
            'price'             => 'required|maxLength:255',
            'photo'             => 'required|maxLength:255'
        ];
    }

    public function getNames() {
        return [
            'client_id'         => 'Cliente',
            'name_id'           => 'Nome do produto',
            'brand_id'          => 'Marca do produto',
            'size_id'           => 'Tamanho do produto',
            'color_id'          => 'Cor do produto',
            'status'            => 'Status',
            'shipping_type'     => 'Tipo de envio',
            'shipping_cost'     => 'Custo do envio',
            'product_code'      => 'Código do produto',
            'quantity'          => 'Quantidade',
            'price'             => 'Preço',
            'photo'             => 'Foto'
        ];
    }

    public function validate($data) {
        return new Validator($data, $this->getRules(), $this->getNames());
    }
}