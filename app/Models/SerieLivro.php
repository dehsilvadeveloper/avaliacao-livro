<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SerieLivro extends Pivot {
    
    use HasFactory;

    protected $table = 'series_livros'; // nome da tabela
    protected $primaryKey = 'cod_serie_livro'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = false; // ativa os campos created_at e updated_at

    protected $fillable = [
        'cod_serie',
        'cod_livro',
        'numero_na_serie'
    ];

    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function livros() {

        // BELONGS TO MANY: model, nome tabela pivot, chave primaria local, chave primaria do model associado
        return $this->belongsToMany(Livro::class, 'autores_livros', 'cod_serie', 'cod_livro')
                    ->using(AutorLivro::class);

    }

}
