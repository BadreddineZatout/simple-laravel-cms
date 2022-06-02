<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CrudLivewireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire:crud 
    {className? : The name of the class}, 
    {modelName? : The name of the model class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Livewire Crud';

    protected $className;
    protected $modelName;

    public function __construct()
    {
        parent::__construct();
        $this->file = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Gather all the parameters
        $this->getParameters();

        // Generate the livewire class
        $this->generateLivewireClass();

        // Generate the livewire view 
        $this->generateLivewireView();
    }

    /**
     * get the class name & model name parametres
     * from the command.
     *
     * @return void
     */
    private function getParameters()
    {
        $this->className = $this->argument('className');
        $this->modelName = $this->argument('modelName');

        if (!$this->className) {
            $this->className = $this->ask('Enter class name');
        }
        if (!$this->modelName) {
            $this->modelName = $this->ask('Enter model name');
        }

        $this->className = Str::studly($this->className);
        $this->modelName = Str::studly($this->modelName);
    }

    /**
     * generate the CRUD livewire class.
     *
     * @return void
     */
    private function generateLivewireClass()
    {
        $fileOrigin = base_path('/stubs/livewire.crud.stub');
        $fileDestinsation = base_path('/app/Http/Livewire/' . $this->className . '.php');

        if ($this->file->exists($fileDestinsation)) {
            $this->info('This class file already exists : ' . $this->className . '.php');
            $this->info('Aborting creation.');
            return false;
        }

        $fileOriginalString = Str::replaceArray(
            '{{}}',
            [
                $this->modelName,
                $this->className,
                $this->modelName,
                $this->modelName,
                $this->modelName,
                $this->modelName,
                $this->modelName,
                Str::kebab($this->className),
            ],
            $this->file->get($fileOrigin)
        );
        $this->file->put($fileDestinsation, $fileOriginalString);
        $this->info('Livewire class file created : ' . $fileDestinsation);
    }

    private function generateLivewireView()
    {
        $fileOrigin = base_path('/stubs/livewire.view.crud.stub');
        $fileDestinsation = base_path('/resources/views/livewire/' . Str::kebab($this->className) . '.blade.php');

        if ($this->file->exists($fileDestinsation)) {
            $this->info('This view file already exists : ' . Str::kebab($this->className) . '.blade.php');
            $this->info('Aborting creation.');
            return false;
        }

        $this->file->copy($fileOrigin, $fileDestinsation);
        $this->info('Livewire view file created : ' . $fileDestinsation);
    }
}
