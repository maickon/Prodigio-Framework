<?php 

namespace App\Models;

use core\ActiveRecord;
use core\Validator;

Class Colors extends ActiveRecord {

    protected $table_name = 'colors';

    private $attributes = [
        'name',
        'created_at'
    ];


    public function getAttributes() {
        return $this->attributes;
    }

    private function getRules() {
        return [
            'name'          => 'required|maxLength:255'
        ];
    }

    public function getNames() {
        return [
            'name'          => 'Nome'
        ];
    }

    public function validate($data) {
        return new Validator($data, $this->getRules(), $this->getNames());
    }
}