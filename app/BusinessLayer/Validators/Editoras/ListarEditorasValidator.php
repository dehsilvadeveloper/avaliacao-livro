<?php
namespace App\BusinessLayer\Validators\Editoras;

use Validator;
use App\Rules\ColunaExisteEmTabelaRule;

class ListarEditorasValidator {

    // Defino propriedades
    private $sucesso;
    private $errosValidacao;
    private $regras = [
        'page' => 'nullable|numeric',
        'page_size' => 'nullable|required_with:page|numeric|max:200',
        'sort' => 'nullable|array'
    ];
    private $mensagens = [
        'page.filled' => 'Você deve informar um valor para a opção PAGE.',
        'page.numeric' => 'A opção PAGE aceita apenas números.',
        'page_size.filled' => 'Você deve informar um valor para a opção PAGE_SIZE.',
        'page_size.required_with' => 'A opção PAGE_SIZE deve ser informada caso a opção PAGE possua um valor.',
        'page_size.max' => 'O número máximo de itens por página é 200. Ajuste sua opção PAGE_SIZE.',
        'page_size.numeric' => 'A opção PAGE_SIZE aceita apenas números.',
        'sort.filled' => 'Você deve informar um valor para a opção SORT.',
        'sort.array' => 'A opção SORT deve conter apenas um vetor com informações para ordenação de resultados.'
    ];

    /**
     * 
     * Executamos validação
     *
     * @access public
     * @param array $dados
     * @return void
     * 
     */
    public function execute(array $dados) : void {

        // Adiciono regras para coluna dentro do array sort, incluindo regra customizada
        $this->regras['sort.*'] = [new ColunaExisteEmTabelaRule('editora')];

        /***************************************
        ::: VERIFICANDO CAMPOS OBRIGATÓRIOS :::
        ****************************************/
        $validacao = Validator::make($dados, $this->regras, $this->mensagens);

        /***************************************
        ::: DEFININDO RESULTADO DA VALIDAÇÃO :::
        ****************************************/
        // Verificamos se algum erro de validação foi obtido
        if ($validacao->fails()) {

            // Indicamos que dados NÃO SÃO VÁLIDOS
            $this->sucesso = false;

            // Colocamos as mensagens de erro obtidas em propriedade da classe. 
            // As mensagens são obtidas no formato array
            $this->errosValidacao = $validacao->errors()->all();

        } else {

            // Indicamos que dados SÃO VÁLIDOS
            $this->sucesso = true;

        }

    }



    /**
     * 
     * Retorna valor da propriedade SUCESSO
     *
     * @access public
     * @return bool
     * 
     */
    public function estaLiberado() : bool {

        return $this->sucesso;

    }



    /**
     * 
     * Retorna valor da propriedade JSON ERROS VALIDAÇÃO
     *
     * @access public
     * @return array
     * 
     */
    public function pegarErros() : array {

        return $this->errosValidacao;

    }



}