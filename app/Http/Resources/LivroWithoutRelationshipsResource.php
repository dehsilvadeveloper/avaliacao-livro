<?php
namespace App\Http\Resources;

use Illuminate\Support\Arr;

class LivroWithoutRelationshipsResource extends LivroResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        // Usamos o método toArray() da classe-pai para gerar o array
        // Então removemos a coluna 'relationships' do array gerado usando Arr::except()
        return Arr::except(
            parent::toArray($request),
            [
                'relationships'
            ]
        );

    }

    

}
