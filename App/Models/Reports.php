<?php 

namespace App\Models;

use core\ActiveRecord;
use core\Validator;

Class Reports extends ActiveRecord {

    protected $table_name = 'reports';
    protected $foreign_relationship = [
        'category_id' => 'categories'
    ];
    private $attributes = [
        'name',
        'category_id',
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
            'name'          => 'required|maxLength:255'
            'category_id'   => 'required|integer'
        ];
    }

    public function getNames() {
        return [
            'name'          => 'Nome',
            'category_id'   => 'Categoria',
        ];
    }

    public function validate($data) {
        return new Validator($data, $this->getRules(), $this->getNames());
    }
}