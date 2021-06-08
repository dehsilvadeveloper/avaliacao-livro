<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable {

    use HasFactory, Notifiable, HasApiTokens;

    // DEFININDO PROPRIEDADES ----------------------------------------------------------------------
    protected $table = 'usuario'; // nome da tabela
    protected $primaryKey = 'cod_usuario'; // chave primária  
    public $incrementing = true; // indica se os IDs são auto-incremento
    public $timestamps = true; // ativa os campos created_at e updated_at

    protected $fillable = [
        'usuario',
        'password',
        'email',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
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
    // Exemplo de uso: Usuario::filtro(['usuario' => 'teste'])->get();
    public function scopeFiltro($query, $params) {

        if (isset($params['usuario']) && $params['usuario'] !== '') {
			$query->where('usuario', '=', $params['usuario']);
		}

		return $query;
        
    }



    // DEFININDO ACCESSORS ---------------------------------------------------------------------



    // DEFININDO MUTATORS ----------------------------------------------------------------------



}
