<?php

namespace IlBronza\Timings\Console\Commands;

use IlBronza\Timings\Helpers\TimingCalculatorHelper;
use Illuminate\Console\Command;

class TimingCalculateByClass extends Command
{
    protected $signature = 'timings:calculateTimings {class=orderProduct : Class key (e.g. orderProduct)}';
    protected $description = 'Calculate timings for a given class key.';

    public function handle(): int
    {
        $class = (string) $this->argument('class');

        TimingCalculatorHelper::calculateByClass($class);

        $this->info("Timings calculated for: {$class}");

        return self::SUCCESS;
    }
}