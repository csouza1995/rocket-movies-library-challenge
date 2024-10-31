<?php

class Session
{
    public static function start(): void
    {
        session_start();
    }

    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function push($key, $value): void
    {
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }

        $_SESSION[$key] = array_merge($_SESSION[$key], $value);
    }

    public static function filter($key, $value): void
    {
        $_SESSION[$key] = array_filter($_SESSION[$key], fn($k) => $k !== $value, ARRAY_FILTER_USE_KEY);
    }

    public static function get($key): mixed
    {
        $value = $_SESSION[$key] ?? null;

        if (is_null($value)) {
            $value = $_SESSION['flash'][$key] ?? null;

            if ($value) {
                self::filter('flash', $key);
            }
        }

        return $value;
    }

    public static function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function forget($key): void
    {
        unset($_SESSION[$key]);
    }

    public static function flash($key, $value): void
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }

        self::push('flash', [$key => $value]);
    }

    public static function destroy(): void
    {
        session_destroy();
    }
}
