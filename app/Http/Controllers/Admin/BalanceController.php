<?php

namespace App\Http\Controllers\Admin;

use App\Historic;
use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyValidationFormRequest;
use Illuminate\Http\Request;
use App\User;

class BalanceController extends Controller
{
    public function index()
    {
    	$balance = auth()->user()->balance;
    	$amount = $balance ? $balance->amount :  0;
    	return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
    	return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
    	$balance = auth()->user()->balance()->firstOrCreate([]);
    	$response = $balance->deposit($request->amount); 
    	
    	if ($response['success']) {
    		return redirect()
    					->route('balance.index')
    					->with('success', $response['message']);
    	}

    	return redirect()
    				->back()
    				->with('error', $response['message']);  	

    }

    public function withdraw()
    {
        return view('admin.balance.withdraw');
    }

    public function withdrawStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->withdraw($request->amount);

        if ($response['success']) {
            return redirect()
                ->route('balance.index')
                ->with('success', $response['message']);
        }

        return redirect()
            ->back()
            ->with('error', $response['message']);
    }

    public function transfer()
    {
        return view('admin.balance.transfer');
    }

    public function confirmTransfer(Request $request, User $user)
    {
        if (! $sender = $user->getSender($request->sender) ) {
            return redirect()
                ->back()
                ->with('error', 'Usuário não foi encontrado');
        }

        if ( $sender->id === auth()->user()->id) {
            return redirect()
                ->back()
                ->with('error', 'Não pode transferir para você mesmo');
        }

        $balance = auth()->user()->balance;

        return view('admin.balance.confirm-transfer', compact('sender', 'balance'));
    }

    public function transferStore(MoneyValidationFormRequest $request, User $user )
    {
        if (! $sender = $user->find($request->sender_id) ) {
            return redirect()
                ->route('balance.transfer')
                ->with('error', 'Recebedor não foi encontrado');
        }


        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->transfer($request->amount, $sender);


        if ($response['success']) {
            return redirect()
                ->route('balance.index')
                ->with('success', $response['message']);
        }


        return redirect()
            ->route('balance.transfer')
            ->with('error', $response['message']);

    }

    public function historics(Historic $historic)
    {
        $historics = auth()->user()->historics()->with(['userSender'])->paginate(2);
        dd($historics);
        $types = $historic->types();
        return view('admin.balance.historics', compact('historics', 'types'));
    }

    public function search(Request $request, Historic $historic)
    {
        $dataForm = $request->except(['_token']);
        $historics = $historic->search($dataForm, 2);
        $types = $historic->types();
        return view('admin.balance.historics', compact('historics', 'types', 'dataForm'));
        
    }




}
