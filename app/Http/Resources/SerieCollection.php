<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SerieCollection extends ResourceCollection {

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        // Percorremos todos os itens e aplicamos o resource adequado a eles, agrupando-os nesse array de saída
        return $this->collection->map(function ($serie) use ($request) {
            return (new SerieResource($serie))->toArray($request);
        });

    }



}
