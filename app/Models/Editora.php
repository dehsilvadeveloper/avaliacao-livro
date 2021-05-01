<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editora extends Model {
    
    use HasFactory;

    protected $table = 'editora'; // nome da tabela
    protected $primaryKey = 'cod_editora'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = true; // ativa os campos created_at e updated_at

    protected $fillable = [
        'nome_fantasia',
        'website'
    ];

    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function livros() {

        // HAS MANY: model, chave estrangeira, chave local
        return $this->hasMany(Livro::class, 'cod_editora', 'cod_editora');

    }

    

}
