<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model {

    use HasFactory;

    // DEFININDO PROPRIEDADES ----------------------------------------------------------------------
    protected $table = 'livro'; // nome da tabela
    protected $primaryKey = 'cod_livro'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = true; // ativa os campos created_at e updated_at

    protected $fillable = [
        'cod_editora',
        'titulo',
        'titulo_original',
        'idioma',
        'isbn_10',
        'isbn_13',
        'data_publicacao',
        'sinopse',
        'total_paginas',
        'tipo_capa',
        'foto_capa',
        'status'
    ];

    protected $attributes = [
       'status' => 1
    ];

    protected $dates = [
        'data_publicacao'
    ];

    protected $appends = [
        'string_tipo_capa',
        'quanto_tempo_registrado'
    ];

    protected $tipos_de_status = array(
        0 => 'inativo',
        1 => 'ativo'
    );

    protected $tipos_de_capa = array(
        1 => 'comum',
        2 => 'dura'
    );



    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function autores() {

        // BELONGS TO MANY: model, nome tabela pivot, chave primaria local, chave primaria do model associado
        return $this->belongsToMany(Autor::class, 'autores_livros', 'cod_livro', 'cod_autor')
                    ->using(AutorLivro::class);

    }

    public function generos() {

        // BELONGS TO MANY: model, nome tabela pivot, chave primaria local, chave primaria do model associado
        return $this->belongsToMany(Genero::class, 'generos_livros', 'cod_livro', 'cod_genero')
                    ->using(GeneroLivro::class);

    }

    public function series() {

        // BELONGS TO MANY: model, nome tabela pivot, chave primaria local, chave primaria do model associado
        return $this->belongsToMany(Serie::class, 'series_livros', 'cod_livro', 'cod_serie')
                    ->withPivot('numero_na_serie')
                    ->using(SerieLivro::class);

    }

    public function editora() {

        // BELONGS TO: model, chave estrangeira, chave primária (customizada) da tabela pai
        return $this->belongsTo(Editora::class, 'cod_editora', 'cod_editora');

    }

    public function avaliacoes() {

        // HAS MANY: model, chave estrangeira, chave local
        return $this->hasMany(Avaliacao::class, 'cod_livro', 'cod_livro');

    }



    // DEFININDO SCOPES ------------------------------------------------------------------------
    // Exemplo de uso: Livro::hoje()->get();
    public function scopeHoje($q) {

        return $q->where('created_at', today());

    }

    // Exemplo de uso: Livro::ativo()->get();
    public function scopeAtivo($q) {

        return $q->where('status', '=', 1);

    }

    // Exemplo de uso: Livro::inativo()->get();
    public function scopeInativo($q) {

        return $q->where('status', '=', 0);

    }

    // Exemplo de uso: Livro::filtro(['titulo' => 'teste', 'idioma' => 'Português'])->get();
    public function scopeFiltro($query, $params) {

        if (isset($params['titulo']) && $params['titulo'] !== '') {
			$query->where('titulo', 'LIKE', '%' . $params['titulo'] . '%');
		}

        if (isset($params['titulo_original']) && $params['titulo_original'] !== '') {
			$query->where('titulo_original', 'LIKE', '%' . $params['titulo_original'] . '%');
		}

        if (isset($params['idioma']) && $params['idioma'] !== '') {
			$query->where('idioma', '=', $params['idioma']);
		}

        if (isset($params['isbn_10']) && $params['isbn_10'] !== '') {
			$query->where('isbn_10', '=', $params['isbn_10']);
		}

        if (isset($params['isbn_13']) && $params['isbn_13'] !== '') {
			$query->where('isbn_13', '=', $params['isbn_13']);
		}

        if (isset($params['data_publicacao']) && $params['data_publicacao'] !== '') {
            $data = date('Y-m-d', strtotime(str_replace('/', '-', $params['data_publicacao'])));
			$query->where('data_publicacao', '=', $data);
		}

        if (isset($params['sinopse']) && $params['sinopse'] !== '') {
			$query->where('sinopse', 'LIKE', '%' . $params['sinopse'] . '%');
		}

        if (isset($params['total_paginas']) && $params['total_paginas'] !== '') {
			$query->where('total_paginas', '=', $params['total_paginas']);
		}

        if (isset($params['tipo_capa']) && $params['tipo_capa'] !== '') {
			$query->where('tipo_capa', '=', $params['tipo_capa']);
		}

        if (isset($params['editora']) && $params['editora'] !== '') {

            $query->whereHas('editora', function($q) use($params) {
                $q->where('nome_fantasia', '=', $params['editora']);
            });

        }

        if (isset($params['autor']) && $params['autor'] !== '') {

            $query->whereHas('autores', function($q) use($params) {
                $q->where('nome', 'LIKE', '%' . $params['autor'] . '%');
            });

        }

        if (isset($params['genero']) && $params['genero'] !== '') {

            $query->whereHas('generos', function($q) use($params) {
                $q->where('nome', '=', $params['genero']);
            });

        }

        if (isset($params['serie']) && $params['serie'] !== '') {

            $query->whereHas('series', function($q) use($params) {
                $q->where('titulo', 'LIKE', '%' . $params['serie'] . '%');
            });

        }

		return $query;
        
    }



    // DEFININDO ACCESSORS ----------------------------------------------------------------------
    public function getStatusAttribute($value) {

        // Retornamos valor de acordo com posição no array que está na propriedade
        return $this->tipos_de_status[$value];

    }

    public function getStringTipoCapaAttribute() {

        if ($this->tipo_capa != '') {

            // Retornamos valor de acordo com posição no array que está na propriedade
            return $this->tipos_de_capa[$this->tipo_capa];

        }

    }

    public function getQuantoTempoRegistradoAttribute() {

        if ($this->created_at != '') {

            return $this->created_at->diffForHumans();

        }

    }



    // DEFININDO MUTATORS ----------------------------------------------------------------------

    

}
