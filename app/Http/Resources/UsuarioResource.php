<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        
        return [
            'cod_usuario' => (int) $this->cod_usuario,
            'usuario' => $this->usuario,
            'email' => $this->email,
            'email_verificado_em' => ($this->email_verified_at != '') ? $this->email_verified_at->format('d/m/Y H:i:s') : null,
            'criado_em' => $this->created_at->format('d/m/Y H:i:s'),
            'atualizado_em' => ($this->updated_at != '') ? $this->updated_at->format('d/m/Y H:i:s') : null
        ];

    }



}
