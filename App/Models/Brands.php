<?php 

namespace App\Models;

use core\ActiveRecord;
use core\Validator;

Class Brands extends ActiveRecord {

    protected $table_name = 'brands';
    protected $foreign_relationship = [
        'fee_id' => 'fees'
    ];
    private $attributes = [
        'name',
        'fee_id',
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
            'name'          => 'required|maxLength:255',
            'fee_id'        => 'required|integer'
        ];
    }

    public function getNames() {
        return [
            'name'          => 'Nome',
            'fee_id'        => 'Taxa'
        ];
    }

    public function validate($data) {
        return new Validator($data, $this->getRules(), $this->getNames());
    }
}