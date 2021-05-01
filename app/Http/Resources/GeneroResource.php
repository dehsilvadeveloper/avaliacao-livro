<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneroResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        
        return [
            'cod_genero' => (int) $this->cod_genero,
            'nome' => $this->nome,
            'criado_em' => $this->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => $this->updated_at->format('d/m/Y H:i:s')
        ];

    }



}
