<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCardTransfersRequest;
use App\Http\Requests\UpdateCardTransfersRequest;
use App\Models\CardTransfers;
use Illuminate\Http\Request;

class CardTransfersController extends Controller
{
    public function index(){
        $transfers = CardTransfers::where('user_id', auth()->user()->id)->get();
        return view('web.transfers.index', compact('transfers'));
    }

    public function data(){
        $search = request('search');
        $firstdate = request('firstdate');
        $lastdate = request('lastdate');

        $sum = CardTransfers::where('user_id', auth()->user()->id)->where('exchange',1);
        $sum_usd = CardTransfers::where('user_id', auth()->user()->id)->where('exchange',2);
        $sum_eur = CardTransfers::where('user_id', auth()->user()->id)->where('exchange',3);
        $sum_azn = CardTransfers::where('user_id', auth()->user()->id)->where('exchange',4);

        $transfers = CardTransfers::where('user_id', auth()->user()->id);

        if (!empty($search)) {       
            $transfers = $transfers->where(function ($q) use ($search) {
                $q->where('card_no', 'like', '%' . $search . '%')
                    ->orWhere('to_card_no', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });    
            $sum = $sum->where(function ($s) use ($search) {
                $s->where('card_no', 'like', '%' . $search . '%')
                    ->orWhere('to_card_no', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });      
            $sum_usd = $sum_usd->where(function ($s) use ($search) {
                $s->where('card_no', 'like', '%' . $search . '%')
                    ->orWhere('to_card_no', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });  
            $sum_eur = $sum_eur->where(function ($s) use ($search) {
                $s->where('card_no', 'like', '%' . $search . '%')
                    ->orWhere('to_card_no', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });  
            $sum_azn = $sum_azn->where(function ($s) use ($search) {
                $s->where('card_no', 'like', '%' . $search . '%')
                    ->orWhere('to_card_no', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });  
        }

        if (!empty($firstdate)) {       
            $transfers = $transfers->where(function ($q) use ($firstdate) {
                $q->whereBetween('created_at', [$firstdate, now()]);
            });   
            
            $sum = $sum->where(function ($s) use ($firstdate) {
                $s->whereBetween('created_at', [$firstdate, now()]);
            }); 
            $sum_usd = $sum_usd->where(function ($s) use ($firstdate) {
                $s->whereBetween('created_at', [$firstdate, now()]);
            }); 
            $sum_eur = $sum_eur->where(function ($s) use ($firstdate) {
                $s->whereBetween('created_at', [$firstdate, now()]);
            }); 
            $sum_azn = $sum_azn->where(function ($s) use ($firstdate) {
                $s->whereBetween('created_at', [$firstdate, now()]);
            }); 
        }elseif (!empty($lastdate)) {       
            $transfers = $transfers->where(function ($q) use ($lastdate) {
                $q->whereBetween('created_at', [0, $lastdate]);
            });  
            
            $sum = $sum->where(function ($s) use ($lastdate) {
                $s->whereBetween('created_at', [$lastdate, now()]);
            }); 
            $sum_usd = $sum_usd->where(function ($s) use ($lastdate) {
                $s->whereBetween('created_at', [$lastdate, now()]);
            });
            $sum_eur = $sum_eur->where(function ($s) use ($lastdate) {
                $s->whereBetween('created_at', [$lastdate, now()]);
            });
            $sum_azn = $sum_azn->where(function ($s) use ($lastdate) {
                $s->whereBetween('created_at', [$lastdate, now()]);
            });
        }elseif (!empty($firstdate and $lastdate)) {       
            $transfers = $transfers->where(function ($q) use ($firstdate, $lastdate) {
                $q->whereBetween('created_at', [$firstdate, $lastdate]);
            });  
            
            $sum = $sum->where(function ($s) use ($firstdate, $lastdate) {
                $s->whereBetween('created_at', [$firstdate, $lastdate]);
            }); 
            $sum_usd = $sum_usd->where(function ($s) use ($firstdate, $lastdate) {
                $s->whereBetween('created_at', [$firstdate, $lastdate]);
            }); 
            $sum_eur = $sum_eur->where(function ($s) use ($firstdate, $lastdate) {
                $s->whereBetween('created_at', [$firstdate, $lastdate]);
            }); 
            $sum_azn = $sum_azn->where(function ($s) use ($firstdate, $lastdate) {
                $s->whereBetween('created_at', [$firstdate, $lastdate]);
            }); 
        }

       
        return response()->json([
            'data' => [$transfers, $sum, $sum_usd, $sum_eur, $sum_azn],
            'table' => view('web.transfers.data', ['transfers'=> $transfers->get(), 'sum' => $sum->sum('amount'), 'sum_usd' => $sum_usd->sum('amount'), 'sum_eur' => $sum_eur->sum('amount'), 'sum_azn' => $sum_azn->sum('amount')])->render()
        ]);
    }

    public function add(AddCardTransfersRequest $request){
        //dd($request->all()); die;
        $data = [
            'user_id' => auth()->user()->id,
            'card_no' => $request->card_no,
            'to_card_no' => $request->to_card_no,
            'record' => $request->record,
            'amount' => $request->amount,
            'exchange' => $request->exchange,
            'created_at' => now()
        ];
        $res = CardTransfers::create($data);
        
        return response()->json([
            'message' => $res ? 'Transfers inserted' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function show($id){
        $res = CardTransfers::find($id);
        $transfers = CardTransfers::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'edit' => $res,
            'data' => view('web.transfers.edit', compact('transfers'))->render()
        ]);
    }

    public function update(UpdateCardTransfersRequest $request){
        $res = CardTransfers::where('id',$request->id)->update($request->all());
        //dd($request->all());
        return response()->json([
            'message' => $res ? 'Transfer update' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function all_delete(){
      
        $ids = request('tIds');
        foreach($ids as $tid){
            $all = CardTransfers::where('id', $tid)->delete();
        }
        
        return response()->json([
            'message'=>'Transfer deleted'
        ]);
    }

    public function delete(){
        $transition = CardTransfers::where('id', request('id'))->delete();
        
        return response()->json([
            'message'=>'Transfer deleted'
        ]);
    }
}
