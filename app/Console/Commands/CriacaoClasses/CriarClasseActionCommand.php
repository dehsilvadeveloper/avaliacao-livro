<?php
namespace App\Console\Commands\CriacaoClasses;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use IlluminateSupportCollection;

class CriarClasseActionCommand extends GeneratorCommand {

    /**
     * The name and signature of the console command.
     *
     * @var string
     * @sample php artisan make:action ApagarLivroAction --pasta=Livros --model=Livro
     */
    protected $signature = 'make:action {name : Nome da classe} {--pasta=Pasta : Pasta onde será salva a classe} {--model=Model : Model que será vinculado a classe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma nova classe do tipo ACTION';

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
            '{{ class }}',
            '{{ model }}'
        );

        $replace = array(
            $this->argument('name'),
            $this->option('model')
        );

        return str_replace($find, $replace, $stub);

    }



    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {

        return base_path() . '/stubs/action.stub';

    }



    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {

        return $rootNamespace . '\BusinessLayer\Actions\\' . $this->option('pasta');

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
