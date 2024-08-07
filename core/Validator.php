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

    public function validate() {
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
    //     'username' => 'alpha_dash',
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
    //     'password' => 'alpha_num',
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
        if(is_array($this->data[$field])) {
            foreach ($this->data[$field] as $key => $file) {
                if($key == 'tmp_name' && is_array($file)) {
                    foreach ($file as $tmp_name) {
                        if (isset($tmp_name) && is_uploaded_file($tmp_name)) {
                            return;
                        }
                        
                        $this->addError($field, 'O campo ' . $field . ' deve ser um arquivo.');
                    }
                    
                }
            }
        } else {
            if (isset($this->data[$field]) && is_uploaded_file($this->data[$field])) {
                return;
            }

            $this->addError($field, 'O campo ' . $field . ' deve ser um arquivo.');
        }
    }

    // Método de validação para verificar o tipo MIME do arquivo
    // $rules = [
    //     'document_file' => 'file|mimetypes:application/msword,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    //     'image_file' => 'file|mimetypes:image/jpeg,image/png,image/gif,image/bmp',
    //     'audio_file' => 'file|mimetypes:audio/mpeg,audio/wav,audio/ogg',
    //     'video_file' => 'file|mimetypes:video/mp4,video/quicktime,video/x-msvideo',
    //     'pdf_file' => 'file|mimetypes:application/pdf',
    //     'excel_file' => 'file|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //     'csv_file' => 'file|mimetypes:text/csv,application/vnd.ms-excel',
    //     'zip_file' => 'file|mimetypes:application/zip,application/x-compressed-zip',
    //     'powerpoint_file' => 'file|mimetypes:application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation',
    //     'json_file' => 'file|mimetypes:application/json',
    //     'xml_file' => 'file|mimetypes:text/xml,application/xml',
    //     'txt_file' => 'file|mimetypes:text/plain',
    //     'html_file' => 'file|mimetypes:text/html',
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
    //     'document_file' => 'file|max_file_size:5', // 5 MB de tamanho máximo
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
}