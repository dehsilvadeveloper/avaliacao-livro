<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\RegistrarUsuarioDto;

// Importo features
use App\BusinessLayer\Features\Usuarios\RegistrarUsuarioFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

class RegistroDeUsuarioController extends Controller {

    // Defino variaveis
    private $registrarUsuarioFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param RegistrarUsuarioFeature $registrarUsuarioFeature
     * @return void
     * 
     */
    public function __construct(
        RegistrarUsuarioFeature $registrarUsuarioFeature
    ) {

        // Instancio features
        $this->registrarUsuarioFeature = $registrarUsuarioFeature;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        // Capto dados da requisição
        $dados = $request->only([      
            'usuario',
            'password',
            'password_confirmation',
            'email'
        ]);

        try {

            // Gero DTO para registro de usuário
            $registrarUsuarioDto = RegistrarUsuarioDto::fromArray($dados);

            // Registrar um novo usuário
            $usuario = $this->registrarUsuarioFeature->execute($registrarUsuarioDto);

        } catch (\Exception | \Error $e) {
              
            $codigoErro = ValidacaoHelper::validarHttpStatusCode($e->getCode());

            // Retorno Erro
            return response()->json(array(
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => 'Usuário criado com sucesso',
            'data' => array(
                'usuario' => $usuario
            )
        ), ResponseHttpCode::OK);



        /*$request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = Usuario::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = auth()->login($user);
        return $this->respondWithToken($token);*/

    }



}
