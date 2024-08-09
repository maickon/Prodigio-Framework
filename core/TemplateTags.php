<?php

namespace core;

class TemplateTags {
    
    public function __call($tag, $properties = []) {
        $tagString = "<{$tag}";
        $validAttributes = [
            'class', 'id', 'style', 'data-', 'href', 'src', 'alt', 'title', 'name', 'type', 'value'
        ];

        if (!empty($properties[0]) && is_array($properties[0])) {
            if ($this->isAssoc($properties[0])) {
                foreach ($properties[0] as $key => $value) {
                    $tagString .= " {$key}=\"{$value}\" ";
                }
            } else {
                foreach ($properties as $property) {
                    $tagString .= " {$property} ";
                }
            }
        } elseif (!empty($properties)) {
            $property = $properties[0];
            if ($this->isValidAttribute($property, $validAttributes)) {
                $tagString .= " {$property} ";
            } else {
                $tagString .= ">{$property}</{$tag}>";
                echo $tagString;
                return;
            }
        }

        $tagString .= ">";
        echo $tagString;
    }

    public function __get($tag) {
        echo "</{$tag}>";
    }

    private function isAssoc($arr) {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public function print($string, $mode = null) {
        switch ($mode) {
            case 'decode':
                echo utf8_decode($string);
                break;
            case 'encode':
                echo utf8_encode($string);
                break;
            default:
                echo $string ;
        }
    }

    private function isValidAttribute($property, $validAttributes) {
        foreach ($validAttributes as $validAttribute) {
            if (strpos($property, $validAttribute) !== false || strpos($property, 'data-') === 0) {
                return true;
            }
        }
        return false;
    }
}
