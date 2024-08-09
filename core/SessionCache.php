<?php

namespace core;

class SessionCache {
    // tempo padrão para expiração do cache (1 hora)
    const DEFAULT_EXPIRATION = 3600;

    // nome da variável de sessão que armazena o cache
    const CACHE_VARIABLE = 'session_cache';

    // armazena o tempo de expiração do cache
    private $expiration;

    /**
     * Construtor da classe
     * @param int $expiration (opcional) tempo de expiração do cache em segundos
     */
    public function __construct($expiration = self::DEFAULT_EXPIRATION) {
        $this->expiration = $expiration;
    }

    /**
     * Armazena um valor no cache
     * @param string $key chave para armazenar o valor
     * @param mixed $value valor a ser armazenado
     */
    public function set($key, $value) {
        // inicia a sessão, se necessário
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // recupera o cache armazenado na sessão, se existir
        $cache = isset($_SESSION[self::CACHE_VARIABLE]) ? $_SESSION[self::CACHE_VARIABLE] : array();

        // adiciona o novo valor ao cache
        $cache[$key] = array(
            'value' => $value,
            'expiration' => time() + $this->expiration
        );

        // armazena o cache na sessão
        $_SESSION[self::CACHE_VARIABLE] = $cache;
    }

    /**
     * Recupera um valor do cache
     * @param string $key chave para recuperar o valor
     * @return mixed|null o valor armazenado, ou null se a chave não existir ou o cache tiver expirado
     */
    public function get($key) {
        // inicia a sessão, se necessário
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // verifica se o cache existe e não expirou
        if (isset($_SESSION[self::CACHE_VARIABLE][$key]) && $_SESSION[self::CACHE_VARIABLE][$key]['expiration'] >= time()) {
            return $_SESSION[self::CACHE_VARIABLE][$key]['value'];
        } else {
            return null;
        }
    }
}
