<?php
namespace Tests\Feature\Endpoints;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\BusinessLayer\ResponseHttpCode;

// Importo Sanctum
use Laravel\Sanctum\Sanctum;

// Importo models
use App\Models\Usuario;
use App\Models\Autor;

class AutorTest extends TestCase {

    use Refreshdatabase;

    /**
     * Método para limpar registros temporários após cada execução de teste
     *
     * @return void
     */
    protected function tearDown() : void {

        Autor::truncate();

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerCriadoPorUsuarioDeApiNaoAutenticado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerCriadoSemNome() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerCriadoSemPais() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerCriadoComPaisQueNaoExiste() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorPodeSerCriado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorComNomeRepetidoNaoPodeSerCriado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorsPodemSerListados() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorsPodemSerListadosComPaginacao() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerAtualizadoPorUsuarioDeApiNaoAutenticado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerAtualizadoSemNome() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerAtualizadoSemPais() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerAtualizadoComPaisQueNaoExiste() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorQueNaoExisteNaoPodeSerAtualizado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorPodeSerAtualizado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorNaoPodeSerApagadoPorUsuarioDeApiNaoAutenticado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorQueNaoExisteNaoPodeSerApagado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAutorPodeSerApagado() {}




}
