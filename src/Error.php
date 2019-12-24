<?php declare(strict_types=1);

namespace ProfoundInventions\Nitpick;

interface Error
{
    public function line(): int;

    public function file(): string;

    public function message(): string;

}