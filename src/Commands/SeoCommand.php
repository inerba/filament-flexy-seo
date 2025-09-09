<?php

namespace Inerba\Seo\Commands;

use Illuminate\Console\Command;

class SeoCommand extends Command
{
    public $signature = 'filament-flexy-seo';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
