<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaisResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        
        return [
            'cod_pais' => (int) $this->cod_pais,
            'nome' => $this->nome,
            'codigo' => $this->codigo
        ];

    }



}
