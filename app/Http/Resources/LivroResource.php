<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LivroResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        return [
            'cod_livro' => (int) $this->cod_livro,
            'titulo' => $this->titulo,
            'titulo_original' => $this->titulo_original,
            /*'idioma' => ucfirst($this->idioma),
            'isbn_10' => $this->isbn_10,
            'isbn_13' => $this->isbn_13,
            'data_publicacao' => $this->data_publicacao->format('d/m/Y'),
            'sinopse' => $this->sinopse,
            'total_paginas' => (int) $this->total_paginas,
            'tipo_capa' => $this->tipo_capa,
            'string_tipo_capa' => $this->string_tipo_capa,
            'foto_capa' => $this->foto_capa,
            'total_avaliacoes' => (int) ($this->avaliacoes_count != '') ? $this->avaliacoes_count : $this->avaliacoes->count(),
            'avaliacao_media' => $this->avaliacoes->avg('nota'),
            'status' => $this->status,
            'criado_em' => $this->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => ($this->updated_at != '') ? $this->updated_at->format('d/m/Y H:i:s') : null,
            'quanto_tempo_registrado' => $this->quanto_tempo_registrado,
            // Relações
            'relationships' => [
                'editora' => new EditoraResource($this->editora),
                'autores' => new AutorCollection($this->whenLoaded('autores')),
                'generos' => new GeneroCollection($this->whenLoaded('generos')),
                'series' => new SerieCollection($this->whenLoaded('series')),
                'avaliacoes' => new AvaliacaoCollection($this->whenLoaded('avaliacoes'))
            ]*/
        ];

    }

    

}
