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
use App\Models\Editora;

/*
Ideias:
- testAvaliacaoDeLivroQueNaoExisteNaoPodeSerCriada
- testAvaliacaoNaoPodeSerCriadaSemUsuario
*/

class EditoraTest extends TestCase {

    use Refreshdatabase;

    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraNaoPodeSerCriadaPorUsuarioNaoAutenticado() {

        // Definimos dados que serão inseridos
        $dados = array(
            'nome_fantasia' => 'Rocco',
            'website' => 'https://www.rocco.com.br'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/editoras', 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::AUTHENTICATION_FAILED);

        // Verifico se o registro não existe no banco de dados
        $this->assertDatabaseMissing('editora', [
            'nome_fantasia' => 'Rocco',
            'website' => 'https://www.rocco.com.br'
        ]);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraNaoPodeSerCriadaSemDados() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/editoras', 
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
                'É obrigatório informar o campo NOME FANTASIA.'
            ],
            'data' => null
        ]);
        
    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraNaoPodeSerCriadaSemCamposObrigatorios() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Definimos dados que serão inseridos
        $dados = array(
            'website' => 'https://www.saraiva.com.br'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/editoras', 
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
                'É obrigatório informar o campo NOME FANTASIA.'
            ],
            'data' => null
        ]);
        
    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraPodeSerCriada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Definimos dados que serão inseridos
        $dados = array(
            'nome_fantasia' => 'Saraiva',
            'website' => 'https://www.saraiva.com.br'
        );

        // Executamos requisição ao endpoint
        $response = $this->post(
            '/api/editoras', 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => true,
            'message' => 'Editora criada com sucesso',
            'data' => array(
                'editora' => array(
                    'nome_fantasia' => 'Saraiva',
                    'website' => 'https://www.saraiva.com.br'
                )
            )
        ]);

        // Verifico se o registro existe no banco de dados
        $this->assertDatabaseHas('editora', [
            'nome_fantasia' => 'Saraiva',
            'website' => 'https://www.saraiva.com.br'
        ]);

        // Removo registros utilizados durante o teste
        $ids_para_remover = array(
            $response->getData()->data->editora->cod_editora
        );

        Editora::destroy($ids_para_remover);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditorasPodemSerListadas() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $editora1 = Editora::factory()->create([
            'nome_fantasia' => 'Rocco',
            'website' => 'https://www.rocco.com.br'
        ]);

        $editora2 = Editora::factory()->create([
            'nome_fantasia' => 'JBC',
            'website' => 'https://www.jbc.com.br'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->get(
            '/api/editoras', 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => true,
            'message' => null,
            'data' => array(
                'editoras' => array(
                    array(
                        'nome_fantasia' => 'Rocco',
                        'website' => 'https://www.rocco.com.br'
                    ),
                    array(
                        'nome_fantasia' => 'JBC',
                        'website' => 'https://www.jbc.com.br'
                    )
                )
            )
        ]);

        // Removo registros utilizados durante o teste
        $ids_para_remover = array(
            $editora1->cod_editora,
            $editora2->cod_editora
        );

        Editora::destroy($ids_para_remover);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraPodeSerVisualizada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $editora1 = Editora::factory()->create([
            'nome_fantasia' => 'Rocco',
            'website' => 'https://www.rocco.com.br'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->get(
            '/api/editoras/' . $editora1->cod_editora, 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => true,
            'message' => null,
            'data' => array(
                'editora' => array(
                    'nome_fantasia' => 'Rocco',
                    'website' => 'https://www.rocco.com.br'
                )
            )
        ]);

        // Removo registros utilizados durante o teste
        $ids_para_remover = array(
            $editora1->cod_editora
        );

        Editora::destroy($ids_para_remover);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraNaoPodeSerAtualizadaPorUsuarioNaoAutenticado() {

        // Criamos registros apenas para o teste
        $editora1 = Editora::factory()->create([
            'nome_fantasia' => 'Rocco',
            'website' => 'https://www.rocco.com.br'
        ]);

        // Definimos dados que serão atualizados
        $dados = array(
            'nome_fantasia' => 'Saraiva',
            'website' => 'https://www.saraiva.com.br'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/editoras/' . $editora1->cod_editora, 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::AUTHENTICATION_FAILED);

        // Removo registros utilizados durante o teste
        $ids_para_remover = array(
            $editora1->cod_editora
        );

        Editora::destroy($ids_para_remover);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraNaoPodeSerAtualizadaSemDados() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $editora1 = Editora::factory()->create([
            'nome_fantasia' => 'Rocco',
            'website' => 'https://www.rocco.com.br'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/editoras/' . $editora1->cod_editora, 
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
                'É obrigatório informar o campo NOME FANTASIA.'
            ],
            'data' => null
        ]);

        // Removo registros utilizados durante o teste
        $ids_para_remover = array(
            $editora1->cod_editora
        );

        Editora::destroy($ids_para_remover);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraNaoPodeSerAtualizadaSemCamposObrigatorios() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $editora1 = Editora::factory()->create([
            'nome_fantasia' => 'Rocco',
            'website' => 'https://www.rocco.com.br'
        ]);

        // Definimos dados que serão inseridos
        $dados = array(
            'website' => 'https://www.saraiva.com.br'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/editoras/' . $editora1->cod_editora, 
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
                'É obrigatório informar o campo NOME FANTASIA.'
            ],
            'data' => null
        ]);

        // Removo registros utilizados durante o teste
        $ids_para_remover = array(
            $editora1->cod_editora
        );

        Editora::destroy($ids_para_remover);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraPodeSerAtualizada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $editora1 = Editora::factory()->create([
            'nome_fantasia' => 'Rocco',
            'website' => 'https://www.rocco.com.br'
        ]);

        // Definimos dados que serão atualizados
        $dados = array(
            'nome_fantasia' => 'Saraiva',
            'website' => 'https://www.saraiva.com.br'
        );

        // Executamos requisição ao endpoint
        $response = $this->put(
            '/api/editoras/' . $editora1->cod_editora, 
            $dados, 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico estrutura da resposta
        $response->assertJson([
            'success' => true,
            'message' => 'Editora atualizada com sucesso',
            'data' => array(
                'editora' => array(
                    'nome_fantasia' => 'Saraiva',
                    'website' => 'https://www.saraiva.com.br'
                )
            )
        ]);

        // Removo registros utilizados durante o teste
        $ids_para_remover = array(
            $editora1->cod_editora
        );

        Editora::destroy($ids_para_remover);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraNaoPodeSerApagadaPorUsuarioNaoAutenticado() {

        // Criamos registros apenas para o teste
        $editora1 = Editora::factory()->create([
            'nome_fantasia' => 'JBC',
            'website' => 'https://www.jbc.com.br'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->delete(
            '/api/editoras/' . $editora1->cod_editora, 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::AUTHENTICATION_FAILED);

        // Removo registros utilizados durante o teste
        $ids_para_remover = array(
            $editora1->cod_editora
        );

        Editora::destroy($ids_para_remover);

    }



    /**
     * Método de teste
     *
     * @return void
     */
    public function testEditoraPodeSerApagada() {

        $this->withoutExceptionHandling();

        // Criamos um usuário apenas para o teste
        $usuario = Usuario::factory()->make();

        // Autenticamos usuário com SANCTUM
        Sanctum::actingAs($usuario, ['*']);

        // Criamos registros apenas para o teste
        $editora1 = Editora::factory()->create([
            'nome_fantasia' => 'JBC',
            'website' => 'https://www.jbc.com.br'
        ]);

        // Executamos requisição ao endpoint
        $response = $this->delete(
            '/api/editoras/' . $editora1->cod_editora, 
            [], 
            ['Accept' => 'application/json']
        );

        // Verifico código de status da resposta
        $response->assertStatus(ResponseHttpCode::OK);

        // Verifico se o registro não existe no banco de dados
        $this->assertDatabaseMissing('editora', [
            'nome_fantasia' => 'JBC',
            'website' => 'https://www.jbc.com.br'
        ]);

    }



}
