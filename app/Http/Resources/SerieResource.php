<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SerieResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        
        return [
            'cod_serie' => (int) $this->cod_serie,
            'titulo' => $this->titulo,
            'criado_em' => $this->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => $this->updated_at->format('d/m/Y H:i:s'),
            // Este trecho só é incluído se esta classe for chamada através do Resource/Collection de "Livro", 
            // indicando colunas adicionais da tabela pivot que liga as entidades "Serie" e "Livro"
            $this->mergeWhen($this->pivot != null, function() {
                return [
                    'pivot' => [
                        'numero_na_serie' => $this->pivot->numero_na_serie
                    ]
                ];
            })
        ];

    }



}
