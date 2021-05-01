<?php
namespace App\Console\Commands\CriacaoClasses;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use IlluminateSupportCollection;

class CriarClasseValidatorCommand extends GeneratorCommand {

    /**
     * The name and signature of the console command.
     *
     * @var string
     * @sample php artisan make:validator CriarLivroValidator --pasta=Livros
     */
    protected $signature = 'make:validator {name : Nome da classe} {--pasta=Pasta : Pasta onde será salva a classe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma nova classe do tipo VALIDATOR';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name) {

        $stub = parent::replaceClass($stub, $name);

        $find = array(
            '{{ class }}'
        );

        $replace = array(
            $this->argument('name')
        );

        return str_replace($find, $replace, $stub);

    }



    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {

        return base_path() . '/stubs/validator.stub';

    }



    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {

        return $rootNamespace . '\BusinessLayer\Validators\\' . $this->option('pasta');

    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {

        return [
            ['name', InputArgument::REQUIRED, 'O nome da classe.']
        ];

    }



}
