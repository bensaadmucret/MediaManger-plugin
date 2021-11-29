<?php

namespace Inc\Base;

class Str
{
    /**
     * @param string $string
     * @return string
     */
    public static function camelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function snakeCase(string $string): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function kebabCase(string $string): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function titleCase(string $string): string
    {
        return ucwords(str_replace('_', ' ', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function studlyCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function plural(string $string): string
    {
        return $string . 's';
    }

    /**
     * @param string $string
     * @return string
     */
    public static function singular(string $string): string
    {
        return rtrim($string, 's');
    }

    /**
     * @param string $string
     * @return string
     */
    public static function slug(string $string): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $string));
    }
    
    /**
     * @param string $string
     * @return string
     */
    public static function slugify(string $string): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function slugifyWithDashes(string $string): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function slugifyWithUnderscores(string $string): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function humanize(string $string): string
    {
        return strtolower(str_replace('_', ' ', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function humanizeWithDashes(string $string): string
    {
        return strtolower(str_replace('_', '-', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function humanizeWithUnderscores(string $string): string
    {
        return strtolower(str_replace('_', '_', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function humanizeWithSpaces(string $string): string
    {
        return strtolower(str_replace('_', ' ', $string));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function humanizeWithSpacesAndDashes(string $string): string
    {
        return strtolower(str_replace('_', '-', $string));
    }
}
