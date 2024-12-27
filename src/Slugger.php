<?php

/**
 * Генерация адреса страницы по правилам транслитерации.
 * Используется два алгоритма: Яндекс и ГОСТ.
 *
 * @author HeoH <heoh@heoh.ru>
 * @link https://heoh.ru
 * @copyright Copyright (c) 2025, HeoH
 */

declare(strict_types=1);

namespace Mrheoh\Slugger;

use Mrheoh\Slugger\Interface\SluggerInterface;
use Mrheoh\Slugger\Interface\Yandex;

class Slugger
{
    /**
     * @param SluggerInterface|null $interface
     * @param bool                  $isLower
     */
    public function __construct(private SluggerInterface|null $interface = null, private readonly bool $isLower = true)
    {
        if (is_null($this->interface)) {
            $this->interface = new Yandex();
        }
    }

    /**
     * Генерация slug
     *
     * @param string $string Строка
     * @param string $separator Разделитель: тире или подчеркивание
     * @return string
     */
    public function make(string $string, string $separator = "-"): string
    {
        $string = trim($string);

        $separator = $separator !== '-' ? '_' : '-';

        $string = html_entity_decode($string);
        $string = $this->clearEmoji($string);
        $string = $this->toLower($string);

        $string = strtr($string, $this->interface->rules());

        $string = preg_replace("/[^A-Za-z0-9_\-.]/", $separator, $string);
        $string = preg_replace('/-+/', '-', $string);
        $string = preg_replace('/_+/', '_', $string);
        $string = ltrim($string, "-");
        $string = rtrim($string, "-");
        $string = ltrim($string, "_");

        return rtrim($string, "_");
    }

    /**
     * Очищение строки от эмодзи
     *
     * @param string $string
     * @return string
     */
    public function clearEmoji(string $string): string
    {
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $cleanText = preg_replace($regexEmoticons, '', $string);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $cleanText = preg_replace($regexSymbols, '', $cleanText);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $cleanText = preg_replace($regexTransport, '', $cleanText);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $cleanText = preg_replace($regexMisc, '', $cleanText);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        return preg_replace($regexDingbats, '', $cleanText);
    }

    /**
     * Конвертирует строку в нижний регистр
     *
     * @param string $string
     * @return string
     */
    private function toLower(string $string): string
    {
        if ($this->isLower) {
            $string = function_exists('mb_strtolower') ? mb_strtolower($string) : strtolower($string);
        }

        return $string;
    }
}
