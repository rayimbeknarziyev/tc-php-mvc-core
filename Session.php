<?php

namespace app\core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION[self::FLASH_KEY]) || !is_array($_SESSION[self::FLASH_KEY])) {
            $_SESSION[self::FLASH_KEY] = [];
        }

        foreach ($_SESSION[self::FLASH_KEY] as $key => &$flashMessage) {
            if (is_array($flashMessage)) {
                $flashMessage['remove'] = true;
            }
        }
    }

    public function setFlash(string $key, string $message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash(string $key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }


    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }



    public function __destruct()
    {
        if (!isset($_SESSION[self::FLASH_KEY]) || !is_array($_SESSION[self::FLASH_KEY])) {
            return;
        }

        foreach ($_SESSION[self::FLASH_KEY] as $key => $flashMessage) {
            if (is_array($flashMessage) && ($flashMessage['remove'] ?? false)) {
                unset($_SESSION[self::FLASH_KEY][$key]);
            }
        }
    }
}
