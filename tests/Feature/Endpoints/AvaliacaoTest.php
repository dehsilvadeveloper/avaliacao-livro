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
use App\Models\Livro;

/*
Ideias:
- testAvaliacaoDeLivroQueNaoExisteNaoPodeSerCriada
- testAvaliacaoNaoPodeSerCriadaSemUsuario
*/

class AvaliacaoTest extends TestCase {

    use Refreshdatabase;




}
