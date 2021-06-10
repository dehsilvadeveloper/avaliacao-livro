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
use App\Models\Pais;
use App\Models\Autor;
use App\Models\Editora;
use App\Models\Genero;
use App\Models\Serie;
use App\Models\Livro;
use App\Models\Avaliacao;

class AvaliacaoTest extends TestCase {

    use Refreshdatabase;

    /**
     * Método para limpar registros temporários após cada execução de teste
     *
     * @return void
     */
    protected function tearDown() : void {

        Usuario::truncate();
        Pais::truncate();
        Autor::truncate();
        Editora::truncate();
        Genero::truncate();
        Serie::truncate();
        Livro::truncate();
        Avaliacao::truncate();

    }



    /**
     * Método para criar registro ficticio de usuário
     *
     * @return void
     */
    protected function usuario() {

        return Usuario::factory()->create();

    }



    /**
     * Método para criar registro ficticio de país
     *
     * @return void
     */
    protected function pais() {

        return Pais::factory()->create();

    }



    /**
     * Método para criar registro ficticio de autor
     *
     * @return void
     */
    protected function autor($pais) {

        return Autor::factory()->for($pais, 'nacionalidade')->create();

    }



    /**
     * Método para criar registro ficticio de editora
     *
     * @return void
     */
    protected function editora() {

        return Editora::factory()->create();

    }



    /**
     * Método para criar registro ficticio de gênero
     *
     * @return void
     */
    protected function genero() {

        return Genero::factory()->create();

    }



    /**
     * Método para criar registro ficticio de série
     *
     * @return void
     */
    protected function serie() {

        return Serie::factory()->create();

    }



    /**
     * Método para criar registro ficticio de livro
     *
     * @return void
     */
    protected function livro() {

        $pais = $this->pais();
        $autor = $this->autor($pais);
        $editora = $this->editora();
        $genero = $this->genero();
        $serie = $this->serie();

        return Livro::factory()
                    ->for($editora, 'editora')
                    ->hasAttached($autor, [], 'autores')
                    ->hasAttached($genero, [], 'generos')
                    ->hasAttached($serie, ['numero_na_serie' => 1], 'series')
                    ->create();

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerCriadaPorUsuarioDeApiNaoAutenticado() {

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        $livro = $this->livro();

        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::AUTHENTICATION_FAILED);

        // Verifico se o registro não existe no banco de dados
        $this->assertDatabaseMissing('avaliacao', [
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerCriadaSemUsuario() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => '',
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'É obrigatório informar o campo USUÁRIO.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerCriadaSemNota() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        $livro = $this->livro();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => '',
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'É obrigatório informar o campo NOTA.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerCriadaSemReview() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        $livro = $this->livro();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => ''
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'É obrigatório informar o campo REVIEW.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerCriadaComIdentificacaoDeLivroQueNaoSejaNumeroInteiro() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/abcd/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'O LIVRO informado não pôde ser localizado. É necessário informar um LIVRO válido.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerCriadaComIdentificacaoDeUsuarioQueNaoSejaNumeroInteiro() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => 'abc',
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'O USUÁRIO informado não pôde ser localizado. É necessário informar um USUÁRIO válido.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerCriadaComNotaQueNaoSejaNumeroInteiro() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        $livro = $this->livro();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 'abcd',
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'O campo NOTA deve conter um número entre 0 e 5.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerCriadaComNotaSuperiorACinco() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        $livro = $this->livro();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 7,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'O valor máximo do campo NOTA é 5.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoDeLivroQueNaoExisteNaoPodeSerCriada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . rand(1000, 2000) . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'O LIVRO informado não pôde ser localizado. É necessário informar um LIVRO válido.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoFeitaPorUsuarioQueNaoExisteNaoPodeSerCriada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => rand(1000, 2000),
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'O USUÁRIO informado não pôde ser localizado. É necessário informar um USUÁRIO válido.'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoPodeSerCriada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        $livro = $this->livro();
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => true,
            'message' => 'Avaliação criada com sucesso',
            'data' => array(
                'nota' => 2,
                'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
            )
        ]);

        // Verifico se o registro existe no banco de dados
        $this->assertDatabaseHas('avaliacao', [
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoRepetidaNoMesmoLivroPorMesmoUsuarioNaoPodeSerCriada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $usuario = $this->usuario();
        $livro = $this->livro();

        // Inserimos o registro da avaliação no banco de dados para garantir que ele já exista antes da execução do endpoint
        Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);
        
        // Definimos dados que serão inseridos
        $dados = array(
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
            $dados,
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::DATA_VALIDATION_FAILED);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'success',
            'message',
            'errors',
            'data'
        ]);

        $response->assertJsonFragment([
            'errors' => array(
                'Já existe uma avaliação deste USUÁRIO para este LIVRO'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacoesDeLivroQueNaoExisteNaoPodemSerListadas() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Executamos requisição ao endpoint
        $response = $this->get(
            '/api/livros/' . rand(1000, 2000) . '/avaliacoes', 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::NOT_FOUND);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => false,
            'message' => 'Livro não localizado',
            'errors' => null,
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacoesDeLivroPodemSerListadas() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario1 = $this->usuario();
        $usuario2 = $this->usuario();

        $avaliacao1 = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario1->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        $avaliacao2 = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario2->cod_usuario,
            'nota' => 5,
            'review' => 'Achei incrível.'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->get(
            '/api/livros/' . $livro->cod_livro . '/avaliacoes', 
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
                    'cod_avaliacao',
                    'nota',
                    'review',
                    'criado_em',
                    'atualizado_em',
                    'relationships' => [
                        'usuario'
                    ]
                ]
            ]
        ]);
        
        $response->assertJsonFragment([
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.',
            'criado_em' => $livro->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => $livro->updated_at->format('d/m/Y H:i:s'),
            'relationships' => [
                'usuario' => [
                    'cod_usuario' => $usuario1->cod_usuario,
                    'usuario' => $usuario1->usuario,
                    'email' => $usuario1->email,
                    'email_verificado_em' => $usuario1->email_verified_at->format('d/m/Y H:i:s'),
                    'criado_em' => $usuario1->created_at->format('d/m/Y H:i:s'),
                    'atualizado_em' => $usuario1->updated_at->format('d/m/Y H:i:s')
                ]
            ]
        ]);

        $response->assertJsonFragment([
            'nota' => 5,
            'review' => 'Achei incrível.',
            'criado_em' => $livro->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => $livro->updated_at->format('d/m/Y H:i:s'),
            'relationships' => [
                'usuario' => [
                    'cod_usuario' => $usuario2->cod_usuario,
                    'usuario' => $usuario2->usuario,
                    'email' => $usuario2->email,
                    'email_verificado_em' => $usuario2->email_verified_at->format('d/m/Y H:i:s'),
                    'criado_em' => $usuario2->created_at->format('d/m/Y H:i:s'),
                    'atualizado_em' => $usuario2->updated_at->format('d/m/Y H:i:s')
                ]
            ]
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacoesDeLivroPodemSerListadasComPaginacao() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario1 = $this->usuario();
        $usuario2 = $this->usuario();
        $usuario3 = $this->usuario();

        $avaliacao1 = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario1->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        $avaliacao2 = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario2->cod_usuario,
            'nota' => 5,
            'review' => 'Achei incrível.'
        ]);

        $avaliacao3 = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario3->cod_usuario,
            'nota' => 4,
            'review' => 'Achei acima da média, mas podia ser melhor.'
        ]);

        $dados_paginacao = array(
            'page' => 1,
            'page_size' => 2,
            'sort' => 'created_at'
        );

        // Executamos requisição ao endpoint
        $response = $this->call(
            'GET', 
            '/api/livros/' . $livro->cod_livro . '/avaliacoes',  
            $dados_paginacao
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'cod_avaliacao',
                    'nota',
                    'review',
                    'criado_em',
                    'atualizado_em',
                    'relationships' => [
                        'usuario'
                    ]
                ]
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total'
            ]
        ]);

        $response->assertJsonFragment([
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.',
            'criado_em' => $livro->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => $livro->updated_at->format('d/m/Y H:i:s'),
            'relationships' => [
                'usuario' => [
                    'cod_usuario' => $usuario1->cod_usuario,
                    'usuario' => $usuario1->usuario,
                    'email' => $usuario1->email,
                    'email_verificado_em' => $usuario1->email_verified_at->format('d/m/Y H:i:s'),
                    'criado_em' => $usuario1->created_at->format('d/m/Y H:i:s'),
                    'atualizado_em' => $usuario1->updated_at->format('d/m/Y H:i:s')
                ]
            ]
        ]);

        $response->assertJsonFragment([
            'nota' => 5,
            'review' => 'Achei incrível.',
            'criado_em' => $livro->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => $livro->updated_at->format('d/m/Y H:i:s'),
            'relationships' => [
                'usuario' => [
                    'cod_usuario' => $usuario2->cod_usuario,
                    'usuario' => $usuario2->usuario,
                    'email' => $usuario2->email,
                    'email_verificado_em' => $usuario2->email_verified_at->format('d/m/Y H:i:s'),
                    'criado_em' => $usuario2->created_at->format('d/m/Y H:i:s'),
                    'atualizado_em' => $usuario2->updated_at->format('d/m/Y H:i:s')
                ]
            ]
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerAtualizadaPorUsuarioDeApiNaoAutenticado() {

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario = $this->usuario();

        $avaliacao = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        // Definimos dados que serão atualizados
        $dados = array(
            'nota' => 5,
            'review' => 'Achei sensacional'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/avaliacoes/' . $avaliacao->cod_avaliacao, 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::AUTHENTICATION_FAILED);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerAtualizadaSemNota() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario = $this->usuario();

        $avaliacao = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        // Definimos dados que serão atualizados
        $dados = array(
            'nota' => '',
            'review' => 'Achei sensacional'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/avaliacoes/' . $avaliacao->cod_avaliacao, 
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
                'É obrigatório informar o campo NOTA.'
            ],
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerAtualizadaSemReview() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario = $this->usuario();

        $avaliacao = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        // Definimos dados que serão atualizados
        $dados = array(
            'nota' => 5,
            'review' => ''
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/avaliacoes/' . $avaliacao->cod_avaliacao, 
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
                'É obrigatório informar o campo REVIEW.'
            ],
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerAtualizadaComNotaQueNaoSejaNumeroInteiro() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario = $this->usuario();

        $avaliacao = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        // Definimos dados que serão atualizados
        $dados = array(
            'nota' => 'abcd',
            'review' => 'Achei sensacional'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/avaliacoes/' . $avaliacao->cod_avaliacao, 
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
                'O campo NOTA deve conter um número entre 0 e 5.'
            ],
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerAtualizadaComNotaSuperiorACinco() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario = $this->usuario();

        $avaliacao = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        // Definimos dados que serão atualizados
        $dados = array(
            'nota' => 7,
            'review' => 'Achei sensacional'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/avaliacoes/' . $avaliacao->cod_avaliacao, 
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
                'O valor máximo do campo NOTA é 5.'
            ],
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoQueNaoExisteNaoPodeSerAtualizada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Definimos dados que serão atualizados
        $dados = array(
            'nota' => 5,
            'review' => 'Achei sensacional'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/avaliacoes/' . rand(1000, 2000), 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::NOT_FOUND);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => false,
            'message' => 'Avaliação não localizada',
            'errors' => null,
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoPodeSerAtualizada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario = $this->usuario();

        $avaliacao = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        // Definimos dados que serão atualizados
        $dados = array(
            'nota' => 5,
            'review' => 'Achei sensacional'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/avaliacoes/' . $avaliacao->cod_avaliacao, 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => true,
            'message' => 'Avaliação atualizada com sucesso',
            'data' => array(
                'nota' => 5,
                'review' => 'Achei sensacional'
            )
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoNaoPodeSerApagadaPorUsuarioDeApiNaoAutenticado() {

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario = $this->usuario();

        $avaliacao = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->delete(
            '/api/avaliacoes/' . $avaliacao->cod_avaliacao, 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::AUTHENTICATION_FAILED);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoQueNaoExisteNaoPodeSerApagada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Executamos requisição ao endpoint
        $response = $this->delete(
            '/api/avaliacoes/' . rand(1000, 2000), 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::NOT_FOUND);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => false,
            'message' => 'Avaliação não localizada',
            'errors' => null,
            'data' => null
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testAvaliacaoPodeSerApagada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $livro = $this->livro();
        $usuario = $this->usuario();

        $avaliacao = Avaliacao::create([
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->delete(
            '/api/avaliacoes/' . $avaliacao->cod_avaliacao, 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico se o registro não existe no banco de dados
        $this->assertDatabaseMissing('avaliacao', [
            'cod_livro' => $livro->cod_livro,
            'cod_usuario' => $usuario->cod_usuario,
            'nota' => 2,
            'review' => 'Achei uma obra mediana. Poderia ser melhor trabalhada.'
        ]);

    }



}
