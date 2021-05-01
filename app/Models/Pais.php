<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model {
    
    use HasFactory;

    protected $table = 'pais'; // nome da tabela
    protected $primaryKey = 'cod_pais'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = false; // ativa os campos created_at e updated_at

    protected $fillable = [
        'nome',
        'codigo'
    ];

    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function autores() {

        // HAS MANY: model, chave estrangeira, chave local
        return $this->hasMany(Autor::class, 'cod_pais', 'cod_pais');

    }



}
