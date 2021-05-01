<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GeneroCollection extends ResourceCollection {

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        // Percorremos todos os itens e aplicamos o resource adequado a eles, agrupando-os nesse array de saída
        return $this->collection->map(function ($genero) use ($request) {
            return (new GeneroResource($genero))->toArray($request);
        });

    }



}
