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
use App\Models\Genero;

class GeneroTest extends TestCase {

    use Refreshdatabase;

    /**
     * Método para limpar registros temporários após cada execução de teste
     *
     * @return void
     */
    protected function tearDown() : void {

        Genero::truncate();

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroNaoPodeSerCriadoPorUsuarioDeApiNaoAutenticado() {

        // Definimos dados que serão inseridos
        $dados = array(
            'nome' => 'Suspense'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/generos', 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::AUTHENTICATION_FAILED);

        // Verifico se o registro não existe no banco de dados
        $this->assertDatabaseMissing('genero', [
            'nome' => 'Suspense'
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroNaoPodeSerCriadoSemNome() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/generos', 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura exata da resposta
        $response->assertExactJson([
            'success' => false,
            'message' => 'Dados informados são inválidos',
            'errors' => [
                'É obrigatório informar o campo NOME.'
            ],
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroComNomeRepetidoNaoPodeSerCriado() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $genero1 = Genero::factory()->create([
            'nome' => 'Suspense'
        ]);

        // Definimos dados que serão inseridos
        $dados = array(
            'nome' => 'Suspense'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/generos', 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura exata da resposta
        $response->assertExactJson([
            'success' => false,
            'message' => 'Dados informados são inválidos',
            'errors' => [
                'Este NOME já foi utilizado por outro item.'
            ],
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroPodeSerCriado() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Definimos dados que serão inseridos
        $dados = array(
            'nome' => 'Terror'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/generos', 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => true,
            'message' => 'Gênero criado com sucesso',
            'data' => array(
                'nome' => 'Terror'
            )
        ]);

        // Verifico se o registro existe no banco de dados
        $this->assertDatabaseHas('genero', [
            'nome' => 'Terror'
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGenerosPodemSerListados() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $genero1 = Genero::factory()->create([
            'nome' => 'Terror'
        ]);

        $genero2 = Genero::factory()->create([
            'nome' => 'Suspense'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->get(
            '/api/generos', 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'cod_genero',
                    'nome',
                    'criado_em',
                    'atualizado_em'
                ]
            ]
        ]);
        
        $response->assertJsonFragment([
            'nome' => 'Terror'
        ]);

        $response->assertJsonFragment([
            'nome' => 'Suspense'
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGenerosPodemSerListadosComPaginacao() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroNaoPodeSerAtualizadoPorUsuarioDeApiNaoAutenticado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroNaoPodeSerAtualizadoSemNome() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroQueNaoExisteNaoPodeSerAtualizado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroPodeSerAtualizado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroNaoPodeSerApagadoPorUsuarioDeApiNaoAutenticado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroQueNaoExisteNaoPodeSerApagado() {}



    /**
     * Método de teste
     *
     * @return void
     */
    public function testGeneroPodeSerApagado() {}




}
