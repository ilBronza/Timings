<?php

namespace IlBronza\Timings\Console\Commands;

use IlBronza\Timings\Helpers\TimingEstimationCalculatorHelper;
use Illuminate\Console\Command;

class TimingEstimationsCalculateByClass extends Command
{
    protected $signature = 'timings:calculateEstimations {class=orderProduct : Class key (e.g. orderProduct)}';
    protected $description = 'Calculate timing estimations for a given class key.';

    public function handle(): int
    {
        $class = (string) $this->argument('class');

        TimingEstimationCalculatorHelper::calculateByClass($class);

        $this->info("Timing estimations calculated for: {$class}");

        return self::SUCCESS;
    }
}