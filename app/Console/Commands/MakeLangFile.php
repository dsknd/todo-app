<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeLangFile extends Command
{
    protected $signature = 'make:lang {name}';

    protected $description = 'Create a new lang file';

    public function handle()
    {
        $name = $this->argument('name');
        $pathJa = lang_path('ja/' . $name . '.php');
        $pathEn = lang_path('en/' . $name . '.php');

        if (!file_exists(dirname($pathJa))) {
            mkdir(dirname($pathJa), 0755, true);
        }
        if (!file_exists(dirname($pathEn))) {
            mkdir(dirname($pathEn), 0755, true);
        }

        file_put_contents($pathJa, "<?php\n\nreturn [\n    //\n];\n");
        file_put_contents($pathEn, "<?php\n\nreturn [\n    //\n];\n");

        $this->info('Lang files created successfully.');
    }
}
