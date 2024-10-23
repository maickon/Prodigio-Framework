<?php

namespace App\Models;
use core\Generate;

class FakeDatabase {

    public $data;

    public function __construct() {
        $this->data = $this->run();
    }

    public function run() {
        $administrators = $this->createAdministrators();
        $clients = $this->createClients();
        $names = $this->createNames();
        $categories = $this->createCategories();
        $colors = $this->createColors();
        $sizes = $this->createSizes();
        $fees = $this->createFee();
        $brands = $this->createBrand();
        $orders = $this->createOrder();

        return [
            'administrators' => $administrators,
            'clients' => $clients,
            'names' => $names,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'fees' => $fees,
            'brands' => $brands,
            'orders' => $orders
        ];
    }

    public function createAdministrators($max = 10) {
        $database = [];
        for ($i = 1; $i < $max; $i++) {
            $database[] = [
                'table' => 'administrators',
                'data' => [
                    'fullname' => 'Usuário ' . $i,
                    'email' => 'usuario' . $i . '@email.com',
                    'password' => password_hash('123456', PASSWORD_DEFAULT)
                ]
            ];
        }

        return $database;
    }

    public function createClients($max = 10) {
        $database = [];

        for ($i = 1; $i < $max; $i++) {
            $name = Generate::getNames();
            $database[] = [
                'table' => 'clients',
                'data' => [
                    'name' => $name . ' '. Generate::getSurname(),
                    'cpf_cnpj' => (mt_rand(1,2) % 2) == 0 ? Generate::generateCpf() : Generate::generateCnpj(),
                    'birth_date' => Generate:: generateRandomBirthDate(),
                    'gender' => Generate::generateRandomGender(),
                    'whatsapp' => Generate::generateBrazilianPhoneNumber(),
                    'phone' => Generate::generateBrazilianPhoneNumber(),
                    'email' => Generate::generateRandomEmail($name),
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'address' => Generate::generateRandomAddress(),
                    'complement' => Generate::generateRandomAddress(),
                    'neighborhood' => Generate::generateRandomNeighborhood(),
                    'city' => Generate::generateRandomCity(),
                    'state' => Generate::generateRandomState(),
                    'zip_code' => Generate::generateRandomZipCode(),
                    'status' => Generate::generateRandomStatus()
                ]
            ];
        }

        return $database;
    }

    private function getClothingItems() {
        $clothing = [
            'BLUSA', 'SAIA', 'CAMISA', 'CROPPED', 'TOP', 'SHORT', 
            'SHORT SAIA', 'BERMUDA', 'CALÇA', 'VESTIDO', 'MACAÇÃO', 
            'BODY', 'REGATA', 'T-SHIRT', 'SUTIÃ', 'BLAZER', 
            'CONJUNTO', 'JAQUETA', 'CASACO', 'MEIA', 'MEIA CALÇA', 
            'LEGGING', 'BIQUINI', 'BODY', 'MAIÔ', 'CALCINHA', 
            'PIJAMA', 'CAMISOLA', 'ROBE', 'BOLSA', 'CARTEIRA', 
            'CLOUTH', 'CINTO', 'OUTROS', 'SAPATO', 'ASSESSORIA'
        ];

        return $clothing[array_rand($clothing)];
    }

    public function createNames($max = 10)
    {
        $database = [];
        for ($i = 1; $i < $max; $i++) {
            $database[] = [
                'table' => 'names',
                'data' => [
                    'name' => $this->getClothingItems()
                ]
            ];
        }

        return $database;
    }

    private function getCategoriesItems() {
        $categories = [
            'ROUPA',
            'MODA PRAIA',
            'PIJAMAS',
            'ACESSÓRIO',
            'CALÇADOS',
            'SERVIÇOS'
        ];
        return $categories[array_rand($categories)];
    }

    public function createCategories($max = 10)
    {
        $database = [];
        for ($i = 1; $i < $max; $i++) {
            $database[] = [
                'table' => 'categories',
                'data' => [
                    'name' => $this->getCategoriesItems()
                ]
            ];
        }

        return $database;
    }

    public function createColors($max = 10)
    {
        $database = [];
        for ($i = 1; $i < $max; $i++) {
            $database[] = [
                'table' => 'colors',
                'data' => [
                    'name' => Generate::getColors()
                ]
            ];
        }

        return $database;
    }

    public function createSizes($max = 10)
    {
        $database = [];
        for ($i = 1; $i < $max; $i++) {
            $database[] = [
                'table' => 'sizes',
                'data' => [
                    'category_id' => mt_rand(1, 4),
                    'name' => Generate::getSizeOptions()
                ]
            ];
        }

        return $database;
    }

    public function createFee($max = 10)
    {
        $database = [];
        for ($i = 1; $i < $max; $i++) {
            $database[] = [
                'table' => 'fees',
                'data' => [
                    'name' => 'Taxa '. $i,
                    'cnpj_fee' => Generate::generateDecimal(1, 0),
                    'icms_fee' => Generate::generateDecimal(1, 0),
                    'advisory_fee' => Generate::generateDecimal(1, 0)
                ]
            ];
        }

        return $database;
    }

    public function createBrand($max = 10)
    {
        $database = [];
        for ($i = 1; $i < $max; $i++) {
            $database[] = [
                'table' => 'brands',
                'data' => [
                    'fee_id' => mt_rand(1, 4),
                    'name' => Generate::generateRandomClothingBrand()
                ]
            ];
        }

        return $database;
    }

    public function createOrder($max = 10)
    {
        $database = [];
        for ($i = 1; $i < $max; $i++) {
            $database[] = [
                'table' => 'orders',
                'data' => [
                    'client_id' => mt_rand(1, 4),
                    'name_id' => mt_rand(1, 4),
                    'brand_id' => mt_rand(1, 4),
                    'size_id' => mt_rand(1, 4),
                    'color_id' => mt_rand(1, 4),
                    'status' => Generate::generateProductStatus(),
                    'shipping_type' => Generate::generateShippingType(),
                    'shipping_cost' => Generate::generateShippingCost(),
                    'product_code' => Generate::generateProductCode(),
                    'quantity' => mt_rand(1,3),
                    'price' => Generate::generateRandomPrice(),
                    'photo' => 'https://i.pinimg.com/236x/ba/e3/5a/bae35a391ef245f6d9df3d21f546304f.jpg'
                ]
            ];
        }

        return $database;
    }
}