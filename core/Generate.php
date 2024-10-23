<?php


namespace core;

class Generate {

	static function getNames() {
        $names = [
            'Maickon', 'Marta', 'Maria', 'Samanta', 'Eric', 'Matheus', 'Dani', 
            'Rodolfo', 'Rodrigo', 'Roger', 'Amanda', 'Rebeca', 'Carlos', 
            'Fernando', 'Fernanda', 'Ana', 'João', 'Gabriel', 'Lucas', 
            'Mariana', 'Luiza', 'Sofia', 'Alice', 'Júlia', 'Rafael', 'Isabela', 
            'Pedro', 'Miguel', 'Lorena', 'Bruno', 'Beatriz', 'Renan', 'Paulo', 
            'Elisa', 'Caio', 'Daniel', 'Carolina', 'Felipe', 'Sarah', 'André', 
            'Giovanna', 'Henrique', 'Yasmin', 'Eduardo', 'Larissa', 'Leandro', 
            'Vinícius', 'Camila', 'Thiago', 'Laura', 'Cecília', 'Hugo'
        ];
        return $names[array_rand($names)];
    }

    static function getSurname() {
        $names =  [
            "Silva", "Santos", "Oliveira", "Pereira", "Costa", 
            "Souza", "Rodrigues", "Almeida", "Nascimento", "Lima", 
            "Araújo", "Martins", "Carvalho", "Rocha", "Ribeiro", 
            "Fernandes", "Gomes", "Barbosa", "Freitas", "Melo", 
            "Correia", "Dias", "Cavalcante", "Cardoso", "Leite", 
            "Miranda", "Teixeira", "Vieira", "Monteiro", "Castro"
        ];
        return $names[array_rand($names)];
    }

    static function generateCpf() {
        $cpf = [];

        for ($i = 0; $i < 9; $i++) {
            $cpf[] = rand(0, 9);
        }

        $cpf[] = self::calculateCheckDigit($cpf, [10, 9, 8, 7, 6, 5, 4, 3, 2]);
        $cpf[] = self::calculateCheckDigit($cpf, [11, 10, 9, 8, 7, 6, 5, 4, 3, 2]);

        return implode('', $cpf);
    }

    static function generateCnpj() {
        $cnpj = [];

        for ($i = 0; $i < 12; $i++) {
            $cnpj[] = rand(0, 9);
        }

        $cnpj[] = self::calculateCheckDigit($cnpj, [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
        $cnpj[] = self::calculateCheckDigit($cnpj, [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);

        return implode('', $cnpj);
    }
    
    static function calculateCheckDigit($baseNumbers, $weights) {
        $sum = 0;

        foreach ($baseNumbers as $i => $number) {
            $sum += $number * $weights[$i];
        }

        $remainder = $sum % 11;
        return ($remainder < 2) ? 0 : 11 - $remainder;
    }

    static function generateBrazilianPhoneNumber() {
        $ddd = rand(11, 99);
        $phoneNumber = '9' . rand(10000000, 99999999);
        return sprintf("(%02d) %s-%s", $ddd, substr($phoneNumber, 0, 5), substr($phoneNumber, 5));
    }

    static function generateRandomBirthDate($startYear = 1970, $endYear = 2003) {
        $year = rand(max(1000, $startYear), min(9999, $endYear));
        $month = rand(1, 12);
        $day = rand(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
        return sprintf("%04d-%02d-%02d", $year, $month, $day);
    }

    static function generateRandomGender() {
        $i = rand(0, 1);
        return $i % 2 == 0 ? 'Masculino' : 'Feminino';
    }

    static function generateRandomEmail($name) {
        $domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'example.com'];
        $randomNumber = rand(1000, 9999);
        $domain = $domains[array_rand($domains)];
        return strtolower(str_replace(' ', '.', $name)) . $randomNumber . '@' . $domain;
    }

    static function generateRandomAddress() {
        $streets = [
            'Main St', 'High St', 'Oak St', 'Pine St', 'Maple Ave',
            'Elm St', 'Cedar Rd', 'Birch Ln', 'Rosewood Dr', 'Willow Way'
        ];
        
        $cities = [
            'São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Curitiba', 
            'Salvador', 'Brasília', 'Fortaleza', 'Porto Alegre', 'Recife', 
            'Manaus'
        ];
        
        
        $street = $streets[array_rand($streets)];
        $city = $cities[array_rand($cities)];
        
        return "$street, $city";
    }

    static function generateRandomNeighborhood() {
        $neighborhoods = [
            'Jardins', 'Ipanema', 'Copacabana', 'Liberdade', 'Moema',
            'Bela Vista', 'Vila Madalena', 'Pinheiros', 'Lapa', 'Santa Teresa'
        ];
        return $neighborhoods[array_rand($neighborhoods)];
    }

    static function generateRandomCity() {
        $cities = [
            'São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Curitiba', 
            'Salvador', 'Brasília', 'Fortaleza', 'Porto Alegre', 'Recife', 
            'Manaus'
        ];
        return $cities[array_rand($cities)];
    }

    static function generateRandomState() {
        $states = [
            'SP', 'RJ', 'MG', 'PR', 'BA', 'DF', 'CE', 'RS', 'PE', 'AM'
        ];
        return $states[array_rand($states)];
    }

    static function generateRandomZipCode() {
        return str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    }

    static function generateRandomStatus() {
        $statuses = ['active', 'inactive', 'pending', 'completed'];
        return $statuses[array_rand($statuses)];
    }

    static function getColors() {
        $colors = [
            'Vermelho', 'Azul', 'Verde', 'Amarelo', 'Preto', 'Branco', 
            'Roxo', 'Laranja', 'Rosa', 'Marrom', 'Cinza', 'Ciano', 
            'Magenta', 'Limão', 'Índigo', 'Violeta', 'Dourado', 'Prata'
        ];
        return $colors[array_rand($colors)];
    }

    static function getSizeOptions() {
        $sizes = [
            '34', '36', '38', '40', '42', '44', '46', '48', '50', '52',
            'PP', 'P', 'M', 'G', 'GG',
            'P M G GG', 
            'P M G GG', 
            'U'
        ];
        return $sizes[array_rand($sizes)];
    }

    static function generateRandomClothingBrand() {
        $prefixes = ['Moda', 'Estilo', 'Chic', 'Trendy', 'Elegance', 'Lux', 'Classic', 'Urban', 'Fashion', 'Vibe'];
        $suffixes = ['Wear', 'Couture', 'Design', 'Apparel', 'Collection', 'Style', 'Attire', 'Clothing', 'Line', 'Outfit'];

        $prefix = $prefixes[array_rand($prefixes)];
        $suffix = $suffixes[array_rand($suffixes)];

        return $prefix . ' ' . $suffix;
    }

    static function generateRandomPrice($min = 10.00, $max = 500.00, $decimals = 2) {
        $price = mt_rand($min * 100, $max * 100) / 100;
        return number_format($price, $decimals, '.', '');
    }

    static function generateProductCode($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $code;
    }

    static function generateProductStatus() {
        $statuses = ['Disponível', 'Fora de Estoque', 'Pré-Venda', 'Descontinuado', 'Sob Encomenda'];
        return $statuses[array_rand($statuses)];
    }

    static function generateShippingType() {
        $shippingTypes = ['Envio Padrão', 'Envio Expresso', 'Entrega pelo Correios', 'Transportadora', 'Envio Grátis'];
        return $shippingTypes[array_rand($shippingTypes)];
    }

    static function generateShippingCost() {
        return number_format(mt_rand(500, 5000) / 100, 2, '.', '');
    }

    static function generateDecimal($integer = 1, $decimal = 0) {
        $integerPart = rand($integer, 9);
        $decimalPart = rand($decimal, 99);
        $formattedDecimal = number_format($integerPart . '.' . $decimalPart, 2, '.', '');
        return $formattedDecimal;
    }
}