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

        /*
        // Podemos colocar o resultado num nível mais abaixo, dentro de um novo array que é retornado
        return [
            'livros' => $this->collection->map(function ($livro) use ($request) {
                return (new LivroResource($livro))->toArray($request);
            })
        ];
        */

        // Percorremos todos os itens e aplicamos o resource adequado a eles, agrupando-os nesse array de saída
        return $this->collection->map(function ($livro) use ($request) {
            return (new LivroResource($livro))->toArray($request);
        });

    }



}
