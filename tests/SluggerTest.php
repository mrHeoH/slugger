<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Mrheoh\Slugger\Slugger::class)]
final class SluggerTest extends TestCase
{
    /**
     * Список тестов:
     * 1.Корректная конвертация при разных интерфейсах
     * 2. Удаление смайликов из строки
     * 3. Удаление пробельных символов
     * 4. Отсутствие повторяющихся символов
     * 5. Отсутствие пробельных и разделителей в начале и в конце строки
     **/


    public static function wordsYandexProvider(): array
    {
        return [
            ['Иван', 'Ivan'],
            ['иван', 'ivan'],
            [' Иван ', 'Ivan'],
            ['-Иван-', 'Ivan'],
            ['_Иван_', 'Ivan'],
            ['_Иван_', 'Ivan'],
            ['_иВан_', 'iVan'],
            ['ёлка', 'yolka'],
            ['елка', 'elka'],
            ['узнаешь', 'uznaesh'],
            ['узнаёшь', 'uznayosh'],
            ['Щука', 'SCHuka'],
            ['Чаща', 'CHascha'],
            ['ЧаЩа', 'CHaSCHa'],
            ['Ваше коммерческое предложение', 'Vashe-kommercheskoe-predlozhenie'],
            ['Ваше  коммерческое  предложение', 'Vashe-kommercheskoe-predlozhenie'],
        ];
    }

    public static function wordsYandexUnderlineProvider(): array
    {
        return [
            ['Иван', 'Ivan'],
            ['иван', 'ivan'],
            ['_иВан_', 'iVan'],
            ['Иван Иванов', 'Ivan_Ivanov'],
            [' Иван Иванов ', 'Ivan_Ivanov'],
            ['Ваше  коммерческое  предложение', 'Vashe_kommercheskoe_predlozhenie'],
        ];
    }

    public static function wordsGostProvider(): array
    {
        return [
            ['Иван', 'Ivan'],
            ['иван', 'ivan'],
            [' Иван ', 'Ivan'],
            ['-Иван-', 'Ivan'],
            ['_Иван_', 'Ivan'],
            ['_Иван_', 'Ivan'],
            ['_иВан_', 'iVan'],
            ['ёлка', 'yolka'],
            ['елка', 'elka'],
            ['узнаешь', 'uznaesh'],
            ['узнаёшь', 'uznayosh'],
            ['Щука', 'SHHuka'],
            ['Чаща', 'CHashha'],
            ['ЧаЩа', 'CHaSHHa'],
            ['Ваше коммерческое предложение', 'Vashe-kommercheskoe-predlozhenie'],
            ['Ваше  коммерческое  предложение', 'Vashe-kommercheskoe-predlozhenie'],
        ];
    }

    #[DataProvider('wordsYandexProvider')]
    public function testYandexConverter(string $string, string $expected): void
    {
        $mode = new \Mrheoh\Slugger\Interface\Yandex();
        $slugger = new Mrheoh\Slugger\Slugger($mode, false);

        $slug = $slugger->make($string);
        $this->assertSame($expected, $slug);

        $slugger = new Mrheoh\Slugger\Slugger($mode, true);

        $slug = $slugger->make($string);
        $this->assertSame(strtolower($expected), $slug);
    }

    #[DataProvider('wordsYandexProvider')]
    public function testYandexConverterWithUnderline(string $string, string $expected): void
    {
        $mode = new \Mrheoh\Slugger\Interface\Yandex();
        $slugger = new Mrheoh\Slugger\Slugger($mode, false);

        $slug = $slugger->make($string, '_');
        $this->assertSame($expected, $slug);

        $slugger = new Mrheoh\Slugger\Slugger($mode, true);

        $slug = $slugger->make($string, '_');
        $this->assertSame(strtolower($expected), $slug);
    }


    #[DataProvider('wordsGostProvider')]
    public function testGostConverter(string $string, string $expected): void
    {
        $mode = new \Mrheoh\Slugger\Interface\Gost();
        $slugger = new Mrheoh\Slugger\Slugger($mode, false);

        $slug = $slugger->make($string);
        $this->assertSame($expected, $slug);

        $slugger = new Mrheoh\Slugger\Slugger($mode, true);

        $slug = $slugger->make($string);
        $this->assertSame(strtolower($expected), $slug);
    }
}
