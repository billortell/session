<?php

namespace Helpers\Session;

/**
 * Class Session
 *
 * Seeks to help manage sessions by key.
 * Perfect for flash messages that get disposed after single-use.
 */
class Session {

    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';

    static $sessionKey = '_flashdata';

    /**
     * Session constructor.
     *
     * @param null $sessionKey
     */
    public function __construct($sessionKey=NULL)
    {
        if ( !empty($sessionKey) ) {
            self::setSessionKey($sessionKey);
        }
        if ( !array_key_exists(self::getSessionKey(), $_SESSION) ) {
            $_SESSION[self::getSessionKey()] = [];
        }
    }

    /**
     * Get all flash messages under set session key
     *
     * @return mixed Session
     */
    static public function get(){
        return $_SESSION[self::getSessionKey()];
    }

    /**
     * Get flash messages by type
     *
     * @param $type
     * @return array
     */
    static public function getByType($type)
    {
        if ( !empty($_SESSION[self::getSessionKey()][$type]) ) {
            return $_SESSION[self::getSessionKey()][$type];
        }
        return [];
    }

    /**
     * Add flash message by type
     *
     * @param $type
     * @param $value
     * @return Session
     */
    static public function add($type, $value){
        if ( empty($_SESSION[self::getSessionKey()][$type]) ) {
            $_SESSION[self::getSessionKey()][$type] = [];
        }
        $_SESSION[self::getSessionKey()][$type][] = $value;
        
    }

    /**
     * Clear stored flash messages by type (eg. INFO, WARNING, ERROR, SUCCESS)
     *
     * @param $type
     * @ Session
     */
    static public function clearByType($type){
        if ( array_key_exists($type, $_SESSION[self::getSessionKey()]) ) {
            $_SESSION[self::getSessionKey()][$type] = [];
        }
        
    }

    /**
     * Clear all stored flash messages
     *
     * @return Session
     */
    static public function clearAll(){
        foreach ( self::getTypes() as $type ) {
            self::clearByType($type);
        }
        
    }

    /**
     * Get session key to store flash messages
     *
     * @return string
     */
    static public function setSessionKey($sessionKey)
    {
        return self::$sessionKey = $sessionKey;
    }

    /**
     * Get session key to store flash messages
     *
     * @return string
     */
    static public function getSessionKey()
    {
        return self::$sessionKey;
    }

    /**
     * Add success
     *
     * @param $value
     * @
     */
    static public function addSuccess($value)
    {
        $type = self::SUCCESS;
        self::add($type, $value);
    }

    /**
     * Add info
     *
     * @param $value
     * @
     */
    static public function addInfo($value)
    {
        $type = self::INFO;
        self::add($type, $value);
    }

    /**
     * Add warning
     *
     * @param $value
     * @
     */
    static public function addWarning($value)
    {
        self::add(self::WARNING, $value);
        
    }

    /**
     * Add error
     *
     * @param $value
     * @
     */
    static public function addError($value)
    {
        self::add(self::ERROR, $value);
        
    }

    /**
     * Get list (array) of all flash message types
     *
     * @return array of session types (key arrays to be set)
     */
    static private function getTypes()
    {
        return [
            self::SUCCESS,
            self::INFO,
            self::WARNING,
            self::ERROR,
        ];
    }

}
