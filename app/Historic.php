<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
	protected $fillable = [
		'type',
		'amount',
		'total_before',
		'total_after',
		'user_id_transaction',
		'date'
	];

	public function userSender()
    {
        return $this->belongsTo(User::class, 'user_id_transaction');
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getTypeAttribute($value)
    {


        if ($this->user_id_transaction != null && $value == 'I') {
            return 'Recebido';
        }

        return $this->types()[$value];
    }

    public function types()
    {
        return  [
            'I' => 'Entrada',
            'O' => 'Saida',
            'T' => 'Transação',
        ];
    }

    public function scopeUserAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function search(array $data, $totalPage)
    {
        return $this->where(function ($query) use($data) {
            
            if (isset($data['id'])) {
                $query->where('id','=', $data['id']);
            }    
            
            if (isset($data['date'])) {
                $query->where('date','=', $data['date']);
            }

            if (isset($data['type'])) {
                $query->where('type','=', $data['type']);
            }

        })
            ->where('user_id', auth()->user()->id)
            ->paginate($totalPage);
    }


}
