<?php

namespace Gdl2Studio\IdeHelper\Console\Commands;

use Exception;
use Gdl2Studio\IdeHelper\Facades\IdeHelper as IdeHelperFacade;
use Illuminate\Console\Command;

class FacadesCommand extends Command
{
    protected $signature = 'ide-helper:facades
                            {--w|write : Write new annotations in facades files. Otherwise just flush it to output.}';

    protected $description = 'Creates PHPDoc annotations for application facades.';

    public function handle()
    {
        try {
            IdeHelperFacade::withWrite($this->option('write'))
                ->parseAppFacades()
                ->getParsedFacades()
                ->whenNotEmpty(function ($facades) {
                    $this->info('Annotations generated for:');

                    return $facades;
                })->each(function ($annotation, $facade) {
                    if ($this->option('write')) {
                        $this->info(' '.$facade);
                    } else {
                        $this->info($facade.': ');
                        $this->line($annotation.PHP_EOL, null, 2);
                    }
                });
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
