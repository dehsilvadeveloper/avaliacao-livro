<?php
namespace App\BusinessLayer;

class ResponseHttpCode {

    /**
     * Exemplo de uso:
     * use App\BusinessLayer\ResponseHttpCode;
     *
     * class TesteController extends Controller {
     *
     * public function algumMetodo() {
     *
     *   // Erro de validação
     *   throw new \Exception(
     *       'Dados de acesso inválidos ou inativos', 
     *       ResponseHttpCode::AUTHENTICATION_FAILED
     *   );
     *
     * }
     */

    // Defino constantes de HTTP STATUS CODE
    public const OK = 200; // 200 = OK
    public const CREATED = 201; // 201 = Created  (para quando o registro for criado com sucesso)
    public const NO_CONTENT = 204; // 204 = No content  (para quando a requisição foi um sucesso, mas nenhum registro foi encontrado)
    public const BAD_REQUEST = 400; // 400 = Bad request
    public const AUTHENTICATION_FAILED = 401; // 401 = Authentication failed
    public const NOT_FOUND = 404; // 404 = Not found
    public const DATA_VALIDATION_FAILED = 422; // 422 = Data validation failed
    public const FAILED_DEPENDENCY = 424; // 424 = Failed dependency
    public const INTERNAL_SERVER_ERROR = 500; // 500 = Internal server error  (para erros gerais do script)

}