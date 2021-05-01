<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model {
    
    use HasFactory;

    // DEFININDO PROPRIEDADES ----------------------------------------------------------------------
    protected $table = 'autor'; // nome da tabela
    protected $primaryKey = 'cod_autor'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = true; // ativa os campos created_at e updated_at

    protected $fillable = [
        'cod_pais',
        'nome',
        'data_nascimento',
        'website',
        'twitter'
    ];

    protected $dates = [
        'data_nascimento'
    ];



    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function nacionalidade() {

        // BELONGS TO: model, chave estrangeira, chave primária (customizada) da tabela pai
        return $this->belongsTo(Pais::class, 'cod_pais', 'cod_pais');

    }

    public function livros() {

        // BELONGS TO MANY: model, nome tabela pivot, chave primaria local, chave primaria do model associado
        return $this->belongsToMany(Livro::class, 'autores_livros', 'cod_autor', 'cod_livro')
                    ->using(AutorLivro::class);

    }



}
