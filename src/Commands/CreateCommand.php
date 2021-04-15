<?php

namespace TomaszTryka\Helpers\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateCommand extends Command
{
    protected $signature = 'generate:helpers-file';
    protected $description = 'Create a app/Helpers/helpers.php file for your project.';

    public function handle()
    {
        $helpersFilePath = app_path('Helpers/helpers.php');

        if (File::exists($helpersFilePath)) {
            $this->info('There is already created a helpers file.');
            return;
        }

        if (!File::exists(app_path() . '/Helpers')) {
            File::makeDirectory(app_path() . '/Helpers');
            $this->info('Created app/Helpers directory.');
        }

        File::put($helpersFilePath, $this->helpersFileContents());
        $this->info('Helpers file was created!');
    }

    protected function helpersFileContents()
    {
        return file_get_contents(str_replace('Commands', 'Helpers' , __DIR__) . '/custom_helpers.php');
    }
}