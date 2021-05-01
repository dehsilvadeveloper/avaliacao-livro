<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AutorLivro extends Pivot {
    
    use HasFactory;

    protected $table = 'autores_livros'; // nome da tabela
    protected $primaryKey = 'cod_autor_livro'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = false; // ativa os campos created_at e updated_at

    protected $fillable = [
        'cod_autor',
        'cod_livro'
    ];

}
