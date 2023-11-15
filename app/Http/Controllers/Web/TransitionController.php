<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddTransitionRequest;
use App\Http\Requests\UpdateTransitionRequest;
use App\Models\Transition;
use Illuminate\Http\Request;

class TransitionController extends Controller
{
    public function index(){
        $transitions = Transition::with('parent')->where('user_id', auth()->user()->id)->get();
        return view('web.transition.index', compact('transitions'));
    }

    public function data(){
        $search = request('search');
        $transitions = Transition::with('childs')
                                    ->where('user_id', auth()->user()->id);

        if (!empty($search)) {       
            $transitions = $transitions->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });         
        }

        return response()->json([
            'data' => $transitions,
            'table' => view('web.transition.data', ['transitions'=>$transitions->get()])->render()
        ]);
    }

    public function add(AddTransitionRequest $request){
        //dd($request->all()); die;
        $data = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'user_id' => auth()->user()->id,
            'created_at' => now()
        ];
        $res = Transition::create($data);
        
        return response()->json([
            'message' => $res ? 'Transition inserted' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function show($id){
        $res = Transition::find($id);
        $transitions = Transition::with('parent')->where('user_id', auth()->user()->id)->get();
        return response()->json([
            'edit' => $res,
            'data' => view('web.transition.edit', compact('transitions'))->render()
        ]);
    }

    public function update(UpdateTransitionRequest $request){
        $res = Transition::where('id',$request->id)->update($request->all());
        //dd($request->all());
        return response()->json([
            'message' => $res ? 'Transition update' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function all_delete(){
        
        // $ids = explode(",", request('id'));
        //$org->products()->find($ids)->delete();
        //$all = Transition::whereIn('id', $ids)->delete();
        $ids = request('tIds');
        foreach($ids as $tid){
            $all = Transition::where('id', $tid)->delete();
        }
        
        return response()->json([
            'message'=>'Transitions deleted'
        ]);
    }

    public function delete(){
        $transition = Transition::where('id', request('id'))->first();
        if($transition->childs()->count() == 0){
            $transition->childs()->delete();
            $transition->delete();
        }
        return response()->json([
            'message'=>'Transition deleted'
        ]);
    }
}
