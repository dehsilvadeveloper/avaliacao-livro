<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvaliacaoResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        
        return[
            'cod_avaliacao' => (int) $this->cod_avaliacao,
            'nota' => (int) $this->nota,
            'review' => $this->review,
            'criado_em' => $this->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => $this->updated_at->format('d/m/Y H:i:s'),
            // Relações
            'relationships' => [
                'usuario' => new UsuarioResource($this->usuario),
                'livro' => new LivroWithoutRelationshipsResource($this->whenLoaded('livro'))
            ]
        ];

    }



}
