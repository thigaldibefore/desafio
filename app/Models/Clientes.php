<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';
    protected $fillable = [        
        'nome',
        'documento',
        'email',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function getClientes($filtros = array())
    {
        $clientes = Clientes::orderBy("nome", "ASC");

        if (array_has($filtros, 'nome') && $filtros['nome'] !== null) {
            $clientes = $clientes->where('nome', 'LIKE', '%' . $filtros['nome'] . '%');
        }

        if (array_has($filtros, 'email') && $filtros['email'] !== null) {
            $clientes = $clientes->where('email', 'LIKE', '%' . $filtros['email'] . '%');
        }

        if (array_has($filtros, 'cidade') && $filtros['cidade'] !== null) {
            $clientes = $clientes->where('cidade', 'LIKE', '%' . $filtros['cidade'] . '%');
        }

        if (array_has($filtros, 'documento') && $filtros['documento'] !== null) {
            $clientes = $clientes->where(function ($query) use ($filtros) {
                $query->where('documento', 'LIKE', '%' . $filtros['documento'] . '%')
                    ->orWhere('documento', 'LIKE', '%' . str_replace(['.', '-'], '', $filtros['documento']) . '%');
            });
        }

        if (array_has($filtros, 'id') && $filtros['id'] !== null) {
            $clientes = $clientes->where('id', $filtros['id']);
        }

        if (array_has($filtros, 'term') && $filtros['term'] !== null) {
            $clientes = $clientes->where(function ($query) use ($filtros) {
                $query->where('nome', 'LIKE', "%" . str_replace(" ", "%", $filtros['term']) . '%')
                    ->orWhere('razao_social', 'LIKE', "%" . str_replace(" ", "%", $filtros['term']) . '%');
            });
        }

        if (array_has($filtros, 'tag_cliente') && $filtros['tag_cliente'] !== null) {
            $tag = $filtros['tag_cliente'];
            $clientes = $clientes->whereHas('tags', function ($q) use ($tag) {
                $q->whereIn('tag_id', (array) $tag);
            });
        }

        if (array_has($filtros, 'contato_cliente') && $filtros['contato_cliente'] !== null) {
            $contato = $filtros['contato_cliente'];
            $clientes = $clientes->whereHas('contatos', function ($q) use ($contato) {
                $q->where('nome', 'LIKE', '%' . $contato . '%');
            });
        }
        if ((array_has($filtros, 'order_field') && $filtros['order_field'] !== null) && (array_has($filtros, 'order') && $filtros['order'] !== null)) {
            $clientes = $clientes->orderBy($filtros['order_field'], $filtros['order']);
        } else {
            $clientes = $clientes->orderBy("nome")->orderBy("created_at", "desc");
        }

        return $clientes;
    }

    public function getStatusLabelAttribute($value)
    {
        if ($this->status == 1) {
            return '<span class="btn border bg-white" style="cursor: default;">Ativo</span>';
        } else if ($this->status == 0) {
            return '<span class="btn border bg-white" style="cursor: default;">Inativo</span>';
        } else if ($this->status == 2) {
            return '<span class="btn border bg-white" style="cursor: default;">Pendente</span>';
        } else {
            return '<span class="btn border bg-white" style="cursor: default;">Desconhecido</span>';
        }
    }

    public function getTipoAttribute($value)
    {
        if ($value == 'F') {
            return 'Física';
        } else {
            if ($value == 'J') {
                return 'Jurídica';
            } else {
                return '';
            }
        }
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'subject', 'subject_type', 'subject_id');
    }

}
