<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\addPaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\AmountSpent;
use App\Models\Expenses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index(){
        $expenses_search = Expenses::whereNotNull('parent_id')->where('user_id', auth()->user()->id)->get();
        $payments = AmountSpent::where('user_id', auth()->user()->id)->get();
        $expenses = Expenses::with('parent')->where('user_id', auth()->user()->id)->get();
        return view('web.payments.index', compact('payments','expenses','expenses_search'));
    }

    public function data(){
        $search = request('search');
       // echo $search; die;
        $firstdate = request('firstdate');
        $lastdate = request('lastdate');

        $sum = AmountSpent::where('user_id', auth()->user()->id)->where('exchange',1);
        $sum_usd = AmountSpent::where('user_id', auth()->user()->id)->where('exchange',2);
        $sum_eur = AmountSpent::where('user_id', auth()->user()->id)->where('exchange',3);
        $sum_azn = AmountSpent::where('user_id', auth()->user()->id)->where('exchange',4);
        $payments = AmountSpent::with('expenses')
                                ->where('user_id', auth()->user()->id);

        if (!empty($search)) {       
            $payments = $payments->where(function ($q) use ($search) {
                $q->where('expenses_id', $search);      
            });  
                  
            $sum = $sum->where(function ($s) use ($search) {
                $s->where('expenses_id', $search);
            }); 
            $sum_usd = $sum_usd->where(function ($s) use ($search) {
                $s->where('expenses_id', $search);
            }); 
            $sum_eur = $sum_eur->where(function ($s) use ($search) {
                $s->where('expenses_id', $search);
            }); 
            $sum_azn = $sum_azn->where(function ($s) use ($search) {
                $s->where('expenses_id', $search);
            }); 
        }

        if (!empty($firstdate)) {       
            $payments = $payments->where(function ($q) use ($firstdate) {
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
            $payments = $payments->where(function ($q) use ($lastdate) {
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
            $payments = $payments->where(function ($q) use ($firstdate, $lastdate) {
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
            'data' => $payments,
            'req' => request()->all(),
            'table' => view('web.payments.data', ['payments' => $payments->get(), 'sum' => $sum->sum('amount'), 'sum_usd' => $sum_usd->sum('amount'), 'sum_eur' => $sum_eur->sum('amount'), 'sum_azn' => $sum_azn->sum('amount')])->render()
        ]);
    }

    public function add(addPaymentRequest $request){
        //dd($request->all()); die;
        $data = [
            'user_id' => auth()->user()->id,
            'expenses_id' => $request->expenses,
            'comment' => $request->record,
            'amount' => $request->amount,
            'exchange' => $request->exchange
        ]; //dd($data); die;
        $res = AmountSpent::create($data);
        
        return response()->json([
            'message' => $res ? 'Payment inserted' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function show($id){
        $res = AmountSpent::find($id);
        $payments = AmountSpent::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'edit' => $res,
            'data' => view('web.payments.edit', compact('payments'))->render()
        ]);
    }

    public function update(UpdatePaymentRequest $request){
        $res = AmountSpent::where('id',$request->id)->update($request->all());
        //dd($request->all());
        return response()->json([
            'message' => $res ? 'Payment update' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function all_delete(){
      
        $ids = request('tIds');
        foreach($ids as $tid){
            $all = AmountSpent::where('id', $tid)->delete();
        }
        
        return response()->json([
            'message'=>'Payment deleted'
        ]);
    }

    public function delete(){
        $payment = AmountSpent::where('id', request('id'))->delete();
        
        return response()->json([
            'message'=>'Payment deleted'
        ]);
    }
}
