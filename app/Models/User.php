<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'editado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function getUser($filtros = array())
    {
        $user = User::orderBy('name', 'ASC');

        if (array_has($filtros, 'id') && $filtros['id'] !== null) {
            $user = $user->where('id', $filtros['id']);
        }

        if (array_has($filtros, 'login') && $filtros['login'] !== null) {
            $user = $user->where('login', 'LIKE', '%' . $filtros['login'] . "%");
        }

        if (array_has($filtros, 'nome') && $filtros['nome'] !== null) {
            $user = $user->where('name', 'LIKE', '%' . $filtros['nome'] . "%");
        }

        if (array_has($filtros, 'email') && $filtros['email'] !== null) {
            $user = $user->where('email', 'LIKE', '%' . $filtros['email'] . "%");
        }

        return $user;
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 0:
                return '<span class="badge badge-danger">Inativo</span>';
                break;
            case 1:
                return '<span class="badge badge-info">Ativo</span>';
                break;
            case 2:
                return '<span class="badge badge-warning">Pendente</span>';
                break;
        }
    }

    public function isAdmin()
    {
        if ($this->nivel == 1) {
            return true;
        } else {
            return false;
        }
    }
}
