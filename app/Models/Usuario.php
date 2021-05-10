<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable {

    use HasFactory, Notifiable;

    // DEFININDO PROPRIEDADES ----------------------------------------------------------------------
    protected $table = 'usuario'; // nome da tabela
    protected $primaryKey = 'cod_usuario'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = true; // ativa os campos created_at e updated_at

    protected $fillable = [
        'usuario',
        'senha',
        'email',
        'email_verified_at'
    ];

    protected $hidden = [
        'senha',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];



    // DEFININDO RELAÇÕES ----------------------------------------------------------------------
    public function avaliacoes() {

        // HAS MANY: model, chave estrangeira, chave local
        return $this->hasMany(Avaliacao::class, 'cod_usuario', 'cod_usuario');

    }

    // DEFININDO SCOPES ------------------------------------------------------------------------

    // DEFININDO ACCESSORS ---------------------------------------------------------------------

    // DEFININDO MUTATORS ----------------------------------------------------------------------



}
