<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LivroCollection extends ResourceCollection {

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        // Podemos colocar o resultado num nível mais abaixo, dentro de um novo array que é retornado
        /*return [
            'data' => $this->collection->map(function ($livro) use ($request) {
                return (new LivroResource($livro))->toArray($request);
            })
        ];*/

        return parent::toArray($request);

    }



}
