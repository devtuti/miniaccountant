<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\Income;
use App\Models\Transition;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
 
    public function index(){
        $transition_search = Transition::with('childs')->where('user_id', auth()->user()->id)->get();
        $incomes = Income::where('user_id', auth()->user()->id)->get();
        $transitions =Transition::with('parent')->where('user_id', auth()->user()->id)->get();
        return view('web.incomes.index', compact('transitions','incomes','transition_search'));
    }

    public function data(){
        $search = request('search');
        $firstdate = request('firstdate');
        $lastdate = request('lastdate');

        $sum = Income::where('user_id', auth()->user()->id)->where('exchange',1);
        $sum_usd = Income::where('user_id', auth()->user()->id)->where('exchange',2);
        $sum_eur = Income::where('user_id', auth()->user()->id)->where('exchange',3);
        $sum_azn = Income::where('user_id', auth()->user()->id)->where('exchange',4);
        $incomes = Income::with('transition')->where('user_id', auth()->user()->id);

        if (!empty($search)) {       
            $incomes = $incomes->where(function ($q) use ($search) {
                $q->where('transition_id', $search);
                    
            });       
            
            $sum = $sum->where(function ($s) use ($search) {
                $s->where('transition_id', $search);
            }); 
            $sum_usd = $sum_usd->where(function ($s) use ($search) {
                $s->where('transition_id', $search);
            });
            $sum_eur = $sum_eur->where(function ($s) use ($search) {
                $s->where('transition_id', $search);
            });
            $sum_azn = $sum_azn->where(function ($s) use ($search) {
                $s->where('transition_id', $search);
            });
        }

        if (!empty($firstdate)) {       
            $incomes = $incomes->where(function ($q) use ($firstdate) {
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
            $incomes = $incomes->where(function ($q) use ($lastdate) {
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
            $incomes = $incomes->where(function ($q) use ($firstdate, $lastdate) {
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
            'data' => [$incomes, $sum, $sum_usd, $sum_eur, $sum_azn],
            'table' => view('web.incomes.data', ['incomes'=> $incomes->get(), 'sum' => $sum->sum('amount'), 'sum_usd' => $sum_usd->sum('amount'), 'sum_eur' => $sum_eur->sum('amount'), 'sum_azn' => $sum_azn->sum('amount')])->render()
        ]);
    }

    public function add(AddIncomeRequest $request){
        //dd($request->all()); die;
        $data = [
            'user_id' => auth()->user()->id,
            'transition_id' => $request->transition,
            'comment' => $request->record,
            'amount' => $request->amount,
            'exchange' => $request->exchange,
            'created_at' => now()
        ];
        
        $res =Income::create($data);
        return response()->json([
            'message' => $res ? 'Income inserted' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function show($id){
        $res = Income::find($id);
        $incomes = Income::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'edit' => $res,
            'data' => view('web.incomes.edit', compact('incomes'))->render()
        ]);
    }

    public function update(UpdateIncomeRequest $request){
        $res = Income::where('id',$request->id)->update($request->all());
        //dd($request->all());
        return response()->json([
            'message' => $res ? 'Income update' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function all_delete(){
      
        $ids = request('tIds');
        foreach($ids as $tid){
            $all = Income::where('id', $tid)->delete();
        }
        
        return response()->json([
            'message'=>'Income deleted'
        ]);
    }

    public function delete(){
        $payment = Income::where('id', request('id'))->delete();
        
        return response()->json([
            'message'=>'Income deleted'
        ]);
    }
}
