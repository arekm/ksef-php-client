<?php

if ( ! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @template TValue
     * @template TArgs
     *
     * @param TValue|Closure(TArgs):TValue $value
     * @param  TArgs  ...$args
     * @return TValue
     */
    function value($value, ...$args)
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }
}

if ( ! function_exists('var_path')) {
    /**
     * Get the path to the var folder.
     *
     * @param  string  $path
     */
    function var_path($path = ''): string
    {
        return realpath(__DIR__ . '/../../var/' . $path);
    }
}

if ( ! function_exists('config_path')) {
    /**
     * Get the path to the config folder.
     *
     * @param  string  $path
     */
    function config_path($path = ''): string
    {
        return realpath(__DIR__ . '/../../config/' . $path);
    }
}

if ( ! function_exists('base_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path
     */
    function base_path($path = ''): string
    {
        return realpath(__DIR__ . '/../../' . $path);
    }
}
