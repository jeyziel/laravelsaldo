<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Balance extends Model
{
	public $timestamps = false;

	public function deposit($value)
	{
	    $value = str_replace(['.',','],['','.'], $value);
		DB::BeginTransaction();

		$totalBefore = $this->amount ?? 0;
		$this->amount += number_format($value, '2','.','');
		$deposit = $this->save();

		$historics = auth()->user()->historics()->create([
			'type' => 'I',
			'amount' => $value,
			'total_before' => $totalBefore,
			'total_after' => $this->amount,
			'date' => date('Ymd')
		]);

		if ($deposit && $historics) {
			DB::commit();
			return [
				'success' => true,
				'message' => "sucesso ao carregar"
			];
		}

		DB::rollback();

		return [
			'success' => false,
			'message' => "falha ao carregar"
		];
	}

	public function withdraw($value)
    {
        $value = str_replace(['.',','],['','.'], $value);
        DB::BeginTransaction();

        if ($value > $this->amount) {
            return [
                'success' => false,
                'message' => 'Saldo insuficiente'
            ];
        }
        $totalBefore = $this->amount ?? 0;
        $this->amount -= number_format($value, '2','.','');
        $deposit = $this->save();

        $historics = auth()->user()->historics()->create([
            'type' => 'O',
            'amount' => $value,
            'total_before' => $totalBefore ,
            'total_after' => $this->amount,
            'date' => date('Ymd')
        ]);

        if ($deposit && $historics) {
            DB::commit();
            return [
                'success' => true,
                'message' => "sucesso ao sacar"
            ];
        }

        DB::rollback();



        return [
            'success' => false,
            'message' => "falha ao sacar"
        ];
    }

    public function transfer($value, User $sender)
    {
        $value = str_replace(['.',','],['','.'], $value);
        DB::BeginTransaction();


        if ($value > $this->amount) {
            return [
                'success' => false,
                'message' => 'Saldo insuficiente, impossivel fazer transferência'
            ];
        }

        //atualiza o próprio saldo
        $totalBefore = $this->amount ?? 0;
        $this->amount -= number_format($value, '2','.','');
        $transfer = $this->save();

        $historics = auth()->user()->historics()->create([
            'type' => 'T',
            'amount' => $value,
            'total_before' => $totalBefore ,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
            'user_id_transaction' => $sender->id
        ]);

        //atualiza o saldo do recebedor
        $senderBalance = $sender->balance()->firstOrCreate([]);
        $senderTotalBefore = $senderBalance->amount ?? 0;
        $senderBalance->amount += number_format($value, '2','.','');
        $senderTransfer = $senderBalance->save();

        $senderhistorics = $sender->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $senderTotalBefore ,
            'total_after' => $senderBalance->amount,
            'date' => date('Ymd'),
            'user_id_transaction' => auth()->user()->id
        ]);

        if ($transfer && $historics && $senderTransfer && $senderhistorics) {
            DB::commit();
            return [
                'success' => true,
                'message' => "sucesso ao Transferir"
            ];
        }

        DB::rollback();



        return [
            'success' => false,
            'message' => "falha ao Transferir"
        ];

    }





}
