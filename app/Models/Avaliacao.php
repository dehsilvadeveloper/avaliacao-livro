<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model {
    
    use HasFactory;

    // DEFININDO PROPRIEDADES ----------------------------------------------------------------------
    protected $table = 'avaliacao'; // nome da tabela
    protected $primaryKey = 'cod_avaliacao'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = true; // ativa os campos created_at e updated_at

    protected $fillable = [
        'cod_livro',
        'cod_usuario',
        'nota',
        'review'
    ];



    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function livro() {

        // BELONGS TO: model, chave estrangeira, chave primária (customizada) da tabela pai
        return $this->belongsTo(Livro::class, 'cod_livro', 'cod_livro');

    }

    public function usuario() {

        // BELONGS TO: model, chave estrangeira, chave primária (customizada) da tabela pai
        return $this->belongsTo(Usuario::class, 'cod_usuario', 'cod_usuario');

    }



}
