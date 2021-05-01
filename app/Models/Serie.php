<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model {
    
    use HasFactory;

    protected $table = 'serie'; // nome da tabela
    protected $primaryKey = 'cod_serie'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = true; // ativa os campos created_at e updated_at

    protected $fillable = [
        'titulo'
    ];

    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function livros() {

        // BELONGS TO MANY: model, nome tabela pivot, chave primaria local, chave primaria do model associado
        return $this->belongsToMany(Livro::class, 'series_livros', 'cod_serie', 'cod_livro')
                    ->using(SerieLivro::class);

    }

    

}
