<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model {
    
    use HasFactory;

    protected $table = 'genero'; // nome da tabela
    protected $primaryKey = 'cod_genero'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = true; // ativa os campos created_at e updated_at

    protected $fillable = [
        'nome'
    ];

    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function livros() {

        // BELONGS TO MANY: model, nome tabela pivot, chave primaria local, chave primaria do model associado
        return $this->belongsToMany(Livro::class, 'generos_livros', 'cod_genero', 'cod_livro')
                    ->using(GeneroLivro::class);

    }
    

}
