<?php

namespace Mrheoh\Slugger\Interface;

interface SluggerInterface
{
    /**
     * Правила транскрибирования русских букв
     *
     * @return array
     */
    public function rules(): array;
}
