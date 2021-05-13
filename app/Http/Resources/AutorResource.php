<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AutorResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        
        return [
            'cod_autor' => (int) $this->cod_autor,
            'nome' => $this->nome,
            'data_nascimento' => ($this->data_nascimento != '') ? $this->data_nascimento->format('d/m/Y') : null,
            'website' => $this->website,
            'twitter' => $this->twitter,
            'criado_em' => $this->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => $this->updated_at->format('d/m/Y H:i:s'),
            // Relações
            'relationships' => [
                'pais' => new PaisResource($this->nacionalidade)
            ]
        ];

    }



}
