<?php 

namespace App\Models;

use core\ActiveRecord;

Class UserExemple extends ActiveRecord {

    protected $table_name = 'usersExemple';

	public function save($user) {
        return $this->insert($user, 'email');
    }

    public function remove($id) {
        return $this->delete($id);
    }

    public function edit($id, $data, $return = false) {
        return $this->update($id, $data, $return);
    }

    public function getUserById($id) {
        return $this->find($id);
    }

    public function getUser($field, $value) {
        return $this->findByField($field, $value);
    }

    public function getAllUsers() {
        return $this->findAll();
    }
}