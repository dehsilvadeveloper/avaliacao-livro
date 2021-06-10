<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication;

    protected static $migrationsRun = false;

    /**
     * Método para preparar ambiente para execução de testes
     *
     * @return void
     */
    public function setUp() : void {

        parent::setUp();
        
        // Verificamos se as migrations já rodaram durante esta execução
        // Em caso negativo, prosseguimos
        if (!static::$migrationsRun) {

            Artisan::call('migrate');
            static::$migrationsRun = true;

        }

    }


}
