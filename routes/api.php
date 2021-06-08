<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function() {

    Route::post('registrar', 'App\Http\Controllers\Api\RegistroDeUsuarioController@store')->name('auth.registro.store');

    Route::get('perfil', 'App\Http\Controllers\Api\AutenticacaoController@show')->name('auth.show');
    Route::post('login', 'App\Http\Controllers\Api\AutenticacaoController@store')->name('auth.store');
    Route::post('logout', 'App\Http\Controllers\Api\AutenticacaoController@destroy')->name('auth.destroy');

});

Route::apiResource('editoras', 'App\Http\Controllers\Api\EditoraController');
//Route::apiResource('editoras.livros', 'App\Http\Controllers\Api\LivroDeEditoraController')->only(['index']);

Route::apiResource('autores', 'App\Http\Controllers\Api\AutorController');
//Route::apiResource('autores.livros', 'App\Http\Controllers\Api\LivroDeAutorController')->only(['index']);

Route::apiResource('generos', 'App\Http\Controllers\Api\GeneroController');
//Route::apiResource('generos.livros', 'App\Http\Controllers\Api\LivroDeGeneroController')->only(['index']);

Route::apiResource('series', 'App\Http\Controllers\Api\SerieController');
//Route::apiResource('series.livros', 'App\Http\Controllers\Api\LivroDeSerieController')->only(['index']);

Route::post('livros/pesquisar', 'App\Http\Controllers\Api\PesquisaLivroController@index')->name('livros.pesquisa.index');
//Route::put('livros/{livro}/foto-capa', 'App\Http\Controllers\Api\FotoCapaDeLivroController@update')->name('livros.foto-capa.update');
Route::apiResource('livros', 'App\Http\Controllers\Api\LivroController');

Route::apiResource('livros.avaliacoes', 'App\Http\Controllers\Api\AvaliacaoDeLivroController')->only(['index', 'store']);

Route::apiResource('avaliacoes', 'App\Http\Controllers\Api\AvaliacaoController')->only(['show', 'update', 'destroy']);

