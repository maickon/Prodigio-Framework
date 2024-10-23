<?php

namespace core;

class Validator {
    protected $data;
    protected $rules;
    protected $errors;
    protected $names;

    public function __construct($data, $rules, $names) {
        $this->data = $data;
        $this->rules = $rules;
        $this->names = $names;
        $this->errors = [];
    }

    protected function validateFieldExists($field) {
        if (!array_key_exists($field, $this->data)) {
            $this->addError($field, "O campo '{$this->names[$field]}' não foi preenchido.");
        }
    }
    public function validate() {
        foreach ($this->rules as $field => $value) {
            $this->validateFieldExists($field);
        }

        foreach ($this->rules as $field => $rules) {
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                $rule = explode(':', $rule);

                $method = 'validate' . ucfirst($rule[0]);

                if (method_exists($this, $method)) {
                    if(isset($this->data[$field])) {
                        $this->$method($field, $rule[1] ?? null);
                    }
                } else {
                    return "Método {$method} não existe!";
                    exit;
                }
            }
        }

        return empty($this->errors);
    }

    protected function addError($field, $message) {
        $this->errors[$field][] = $message;
    }

    public function getErrors() {
        return $this->errors;
    }

    // Validar se um campo não está vazio
    // $rules = [
    //     'name' => 'required',
    // ];
    protected function validateRequired($field) {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' é obrigatório.');
        }
    }

    // Validar se um campo é um email
    // $rules = [
    //     'email' => 'required|email',
    // ];
    protected function validateEmail($field) {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um endereço de e-mail válido.');
        }
    }

    // Método de validação para verificar se um campo possui no mínimo X caracteres
    // $rules = [
    //     'name' => 'required|minLength:3|maxLength:50',
    // ];
    protected function validateMinLength($field, $value) {
        if (strlen($this->data[$field]) < $value) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ter pelo menos ' . $value . ' caracteres.');
        }
    }

    // Método de validação para verificar se um campo possui no máximo X caracteres
    // $rules = [
    //     'name' => 'required|minLength:3|maxLength:50',
    // ];
    protected function validateMaxLength($field, $value) {
        if (strlen($this->data[$field]) > $value) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' não pode ter mais de ' . $value . ' caracteres.');
        }
    }

    // Método de validação para verificar se um campo é um número
    // $rules = [
    //     'age' => 'required|numeric',
    // ];
    protected function validateNumeric($field) {
        if (!is_numeric($this->data[$field])) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um número.');
        }
    }

    // Método de validação para verificar se um campo é porcentagem
    // $rules = [
    //     'fee' => 'required|Percentage',
    // ];
    protected function validatePercentage($field) {
        $value = $this->data[$field];

        // Verifica se o valor é um número inteiro ou decimal
        if (is_numeric($value) && ($this->isInteger($value) || $this->isDecimal($value))) {
            return true;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um número inteiro ou decimal válido.');
        return false;
    }

    // Método auxiliar para verificar se é um número inteiro
    protected function isInteger($value) {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    // Método auxiliar para verificar se é um número decimal
    protected function isDecimal($value) {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false && strpos((string)$value, '.') !== false;
    }

    // Método de validação para verificar se um campo é uma URL válida
    // $rules = [
    //     'website' => 'url',
    // ];
    protected function validateUrl($field) {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser uma URL válida.');
        }
    }

    // Método de validação para verificar se um campo é uma data válida
    // $rules = [
    //     'birthdate' => 'required|date',
    // ];
    protected function validateDate($field) {
        $value = $this->data[$field];
        if (!strtotime($value)) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser uma data válida.');
        }
    }

    // Método de validação para verificar o formato de data
    // $rules = [
    //     'birthdate' => 'required|date_format:Y-m-d',
    // ];
    protected function validateDateFormat($field, $format) {
        $value = $this->data[$field];
        $parsedDate = date_parse_from_format($format, $value);
        
        if ($parsedDate['error_count'] === 0 && $parsedDate['warning_count'] === 0) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve corresponder ao formato de data ' . $format . '.');
    }

    // Método de validação para verificar se o campo é uma data posterior
    //  $rules = [
    //     'event_date' => 'required|after:2023-09-25',
    // ];
    protected function validateAfter($field, $date) {
        $value = $this->data[$field];
        $parsedValue = strtotime($value);
        $parsedDate = strtotime($date);

        if ($parsedValue > $parsedDate) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser uma data posterior a ' . $date . '.');
    }

    // Método de validação para verificar se o campo é uma data anterior
    //  $rules = [
    //     'expiry_date' => 'required|before:2023-12-31',
    // ];
    protected function validateBefore($field, $date) {
        $value = $this->data[$field];
        $parsedValue = strtotime($value);
        $parsedDate = strtotime($date);

        if ($parsedValue < $parsedDate) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser uma data anterior a ' . $date . '.');
    }

    // Método de validação para verificar se o campo é um número inteiro
    // $rules = [
    //     'age' => 'required|integer',
    // ];
    protected function validateInteger($field) {
        $value = $this->data[$field];

        if (is_numeric($value) && intval($value) == $value) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um número inteiro.');
    }

    // Método de validação para verificar se o campo contém apenas caracteres alfabéticos
    // $rules = [
    //     'password' => 'alpha',
    // ];
    protected function validateAlpha($field) {
        $value = $this->data[$field];

        if (preg_match('/^[a-zA-Z]+$/', $value)) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve conter apenas caracteres alfabéticos.');
    }

    // Método de validação para verificar se o campo contém apenas letras, números, hífens e sublinhados
    // $rules = [
    //     'username' => 'alphaDash',
    // ];
    protected function validateAlphaDash($field) {
        $value = $this->data[$field];

        if (preg_match('/^[a-zA-Z0-9-_]+$/', $value)) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve conter apenas letras, números, hífens e sublinhados.');
    }

    // Método de validação para verificar se o campo contém apenas letras e números
    // $rules = [
    //     'password' => 'alphaNum',
    // ];
    protected function validateAlphaNum($field) {
        $value = $this->data[$field];

        if (preg_match('/^[a-zA-Z0-9]+$/', $value)) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve conter apenas letras e números.');
    }

    // Método de validação para verificar se o campo está entre os valores especificados
    // $rules = [
    //     'color' => 'in:red,green,blue',
    // ];
    protected function validateIn($field, $values) {
        $value = $this->data[$field];

        if (in_array($value, explode(',', $values))) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve estar entre os valores especificados.');
    }

    // Método de validação para verificar se o campo não está entre os valores especificados
    // $rules = [
    //     'category' => 'not_in:spam,porn,illegal',
    // ];
    protected function validateNotIn($field, $values) {
        $value = $this->data[$field];

        if (!in_array($value, explode(',', $values))) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' não deve estar entre os valores especificados.');
    }

    // Método de validação para verificar se o campo corresponde à expressão regular especificada
    // $rules = [
    //     'email' => 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
    // ];
    protected function validateRegex($field, $pattern) {
        $value = $this->data[$field];

        if (preg_match($pattern, $value)) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' não corresponde ao padrão especificado.');
    }

    // Método de validação para verificar se o campo é confirmado com um campo de confirmação correspondente
    // $rules = [
    //     'password' => 'confirmed:password_confirmation',
    // ];
    protected function validateConfirmed($field, $confirmationField) {
        $value = $this->data[$field];
        $confirmationValue = $this->data[$confirmationField];

        if ($value === $confirmationValue) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' não corresponde ao campo de confirmação.');
    }

    // Método de validação para verificar o tamanho do campo
    // $rules = [
    //     'username' => 'size:8',
    // ];
    protected function validateSize($field, $size) {
        $value = $this->data[$field];

        if (strlen($value) == $size) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ter um tamanho de ' . $size . ' caracteres.');
    }

    // Método de validação para verificar se o campo é diferente do campo especificado
    // $rules = [
    //     'new_password' => 'different:current_password',
    // ];
    protected function validateDifferent($field, $otherField) {
        $value = $this->data[$field];
        $otherValue = $this->data[$otherField];

        if ($value !== $otherValue) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser diferente do campo ' . $this->names[$otherField] . '.');
    }

    // Método de validação para verificar se o campo é igual ao campo especificado
    // $rules = [
    //     'email' => 'same:confirmed_email',
    // ];
    protected function validateSame($field, $otherField) {
        $value = $this->data[$field];
        $otherValue = $this->data[$otherField];

        if ($value === $otherValue) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser igual ao campo ' . $this->names[$otherField] . '.');
    }

    // Método de validação para verificar se o campo atende ao valor mínimo
    // $rules = [
    //     'age' => 'min:18',
    // ];
    protected function validateMin($field, $minValue) {
        $value = $this->data[$field];

        if (is_numeric($value) && $value >= $minValue) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ter um valor mínimo de ' . $minValue . '.');
    }

    // Método de validação para verificar se o campo atende ao valor máximo
    // $rules = [
    //     'weight' => 'max:200',
    // ];
    protected function validateMax($field, $maxValue) {
        $value = $this->data[$field];

        if (is_numeric($value) && $value <= $maxValue) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ter um valor máximo de ' . $maxValue . '.');
    }

    // Método de validação para verificar se o campo está dentro de um intervalo específico
    // $rules = [
    //     'age' => 'between:18,65',
    // ];
    protected function validateBetween($field, $values) {
        list($minValue, $maxValue) = explode(',', $values);

        $value = $this->data[$field];

        if (is_numeric($value) && $value >= $minValue && $value <= $maxValue) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve estar dentro do intervalo entre ' . $minValue . ' e ' . $maxValue . '.');
    }

    // Método de validação para verificar se o campo não está dentro de um intervalo específico
    // $rules = [
    //     'weight' => 'not_between:0,200',
    // ];
    protected function validateNotBetween($field, $values) {
        list($minValue, $maxValue) = explode(',', $values);

        $value = $this->data[$field];

        if (is_numeric($value) && ($value < $minValue || $value > $maxValue)) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' não deve estar dentro do intervalo entre ' . $minValue . ' e ' . $maxValue . '.');
    }

    // Método de validação para verificar se o campo é "aceito"
    // $rules = [
    //     'terms' => 'accepted',
    // ];
    protected function validateAccepted($field) {
        $value = $this->data[$field];

        if ($value === '1' || $value === 'true' || $value === 'yes' || $value === 'sim') {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser aceito.');
    }

    // Método de validação para verificar se o campo é booleano
    // $rules = [
    //     'is_active' => 'boolean',
    // ];
    protected function validateBoolean($field) {
        $value = $this->data[$field];

        if (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser verdadeiro ou falso.');
    }

    // Método de validação para verificar se o campo é um endereço IP válido
    // $rules = [
    //     'ip_address' => 'ip',
    // ];
    protected function validateIp($field) {
        $value = $this->data[$field];

        if (filter_var($value, FILTER_VALIDATE_IP) !== false) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um endereço IP válido.');
    }

    // Método de validação para verificar se o campo é uma string JSON válida
    // $rules = [
    //     'data_json' => 'json',
    // ];
    protected function validateJson($field) {
        $value = $this->data[$field];

        if (json_decode($value) !== null && json_last_error() === JSON_ERROR_NONE) {
            return;
        }

        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser uma string JSON válida.');
    }

    // Método de validação para verificar se o campo é um arquivo
    // $rules = [
    //     'document_file' => 'file',
    // ];

    protected function validateFile($field) {
        if (!isset($this->data[$field])) {
            $this->addError($field, "O campo {$field} é obrigatório.");
            return;
        }

        $file = $this->data[$field];

        if (is_array($file)) {
            // Caso de upload múltiplo
            if (isset($file['tmp_name']) && is_array($file['tmp_name'])) {
                foreach ($file['tmp_name'] as $index => $tmp_name) {
                    if (empty($tmp_name) || !is_uploaded_file($tmp_name)) {
                        $this->addError($field, "O arquivo #{$index} em {$field} não é válido.");
                    }
                }
            } else {
                // Caso de upload único com array de informações
                if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
                    $this->addError($field, "O campo {$field} deve conter um arquivo válido.");
                }
            }
        } elseif (is_string($file)) {
            // Caso de upload único com caminho do arquivo
            if (empty($file) || !is_uploaded_file($file)) {
                $this->addError($field, "O campo {$field} deve ser um arquivo válido.");
            }
        } else {
            $this->addError($field, "O campo {$field} contém um valor inválido.");
        }
    }

    // Método de validação para verificar o tipo MIME do arquivo
    // $rules = [
    //     'document_file' => 'file|mimeTypes:application/msword,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    //     'image_file' => 'file|mimeTypes:image/jpeg,image/png,image/gif,image/bmp',
    //     'audio_file' => 'file|mimeTypes:audio/mpeg,audio/wav,audio/ogg',
    //     'video_file' => 'file|mimeTypes:video/mp4,video/quicktime,video/x-msvideo',
    //     'pdf_file' => 'file|mimeTypes:application/pdf',
    //     'excel_file' => 'file|mimeTypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //     'csv_file' => 'file|mimeTypes:text/csv,application/vnd.ms-excel',
    //     'zip_file' => 'file|mimeTypes:application/zip,application/x-compressed-zip',
    //     'powerpoint_file' => 'file|mimeTypes:application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation',
    //     'json_file' => 'file|mimeTypes:application/json',
    //     'xml_file' => 'file|mimeTypes:text/xml,application/xml',
    //     'txt_file' => 'file|mimeTypes:text/plain',
    //     'html_file' => 'file|mimeTypes:text/html',
    // ];

    protected function validateMimeTypes($field, $allowedMimeTypes) {
        if(is_array($this->data[$field])) {
            foreach ($this->data[$field] as $key => $file) {
                if($key == 'tmp_name' && is_array($file)) {
                    foreach ($file as $tmp_name) {
                        if (isset($tmp_name) && is_uploaded_file($tmp_name)) {
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $tmp_name);
                            finfo_close($finfo);

                            if (in_array($mime, explode(",", $allowedMimeTypes))) {
                                return;
                            }
                        } 
                        
                        $this->addError($field, 'O campo ' . $field . ' não possui um tipo de arquivo permitido.');
                    }
                }
            }
        } else {
            if (isset($this->data[$field]) && is_uploaded_file($this->data[$field])) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $this->data[$field]);
                finfo_close($finfo);

                if (in_array($mime, explode(",", $allowedMimeTypes))) {
                    return;
                }
            }
            
            $this->addError($field, 'O campo ' . $this->data[$field] . ' não possui um tipo de arquivo permitido.');
        }

    }

    // Método de validação para verificar o tamanho máximo de um arquivo em MB
    // $rules = [
    //     'document_file' => 'file|maxFileSize:5', // 5 MB de tamanho máximo
    // ];
    protected function validateMaxFileSize($field, $parameters) {
        if(is_array($this->data[$field])) {
            foreach ($this->data[$field] as $key => $file) {
                if($key == 'size' && is_array($file)) {
                    foreach ($file as $size) {
                        if (!isset($size) || !is_file($size)) {
                            return;
                        }

                        $maxSizeInMB = (float) $parameters;
                        $maxFileSizeInBytes = $maxSizeInMB * 1024 * 1024; // Convertendo MB para bytes

                        if (filesize($size) > $maxFileSizeInBytes) {
                            $this->addError($field, 'O arquivo ' . $field . ' deve ter no máximo $maxSizeInMB MB.');
                        }
                    }
                }
            }
        } else {
            if (!isset($this->data[$field]) || !is_file($this->data[$field])) {
                return;
            }

            $maxSizeInMB = (float) $parameters;
            $maxFileSizeInBytes = $maxSizeInMB * 1024 * 1024; // Convertendo MB para bytes
            if (filesize($size) > $maxFileSizeInBytes) {
                $this->addError($field, 'O arquivo ' . $this->data[$field] . ' deve ter no máximo $maxSizeInMB MB.');
            }
        }
    }

    // Método de validação para verificar se o CPF é válido
    protected function validateCpf($field) {
        $value = preg_replace('/\D/', '', $this->data[$field]); // Remove caracteres não numéricos

        if (strlen($value) !== 11 || !$this->isCpfValid($value)) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um CPF válido.');
        }
    }

    // Método auxiliar para verificar a validade do CPF
    private function isCpfValid($cpf) {
        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false; // CPF inválido
        }

        // Validação dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false; // CPF inválido
            }
        }

        return true; // CPF válido
    }

    // Método de validação para verificar se o CNPJ é válido
    protected function validateCnpj($field) {
        $value = preg_replace('/\D/', '', $this->data[$field]); // Remove caracteres não numéricos

        if (strlen($value) !== 14 || !$this->isCnpjValid($value)) {
            $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um CNPJ válido.');
        }
    }

    // Método auxiliar para verificar a validade do CNPJ
    private function isCnpjValid($cnpj) {
        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false; // CNPJ inválido
        }

        // Validação dos dígitos verificadores
        $valid = false;
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj[$c] != $d) {
                return false; // CNPJ inválido
            }
        }

        return true; // CNPJ válido
    }

    // Método que verifica se um valor é um CPF ou CNPJ válido
    protected function validateCpfOrCnpj($field) {
        $value = preg_replace('/\D/', '', $this->data[$field]); // Remove caracteres não numéricos

        // Verifica se é um CPF
        if (strlen($value) === 11 && $this->isCpfValid($value)) {
            return true; // CPF válido
        }

        // Verifica se é um CNPJ
        if (strlen($value) === 14 && $this->isCnpjValid($value)) {
            return true; // CNPJ válido
        }

        // Se não for CPF ou CNPJ válido, retorna false
        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um CPF ou CNPJ válido.');
        return false; 
    }

    // Método que valida um número de telefone brasileiro
    protected function validatePhoneNumber($field) {
        // Remove caracteres não numéricos
        $value = preg_replace('/\D/', '', $this->data[$field]);

        // Verifica se o número tem 10 ou 11 dígitos (com DDD)
        if (strlen($value) === 10 || strlen($value) === 11) {
            return true; // Número de telefone válido
        }

        // Se o número não for válido, adiciona um erro
        $this->addError($field, 'O campo ' . $this->names[$field] . ' deve ser um número de telefone válido.');
        return false; 
    }

}