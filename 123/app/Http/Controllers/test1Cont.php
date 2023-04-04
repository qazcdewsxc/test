<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\test1;
use App\Models\User;
use App\Http\Requests\test1Req;
use App\Http\Requests\test1UpReq;
use App\Http\Requests\LogReq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class test1Cont extends Controller
{
    public function shw()
    {
        if(Auth::user()->hasRole('admin'))
        {
            $test1 = JsonResource::collection(test1::all());
            $page = 'create';
            return view('welcome', compact('test1', 'page'));
        }
        else 
        {
            $test1 = JsonResource::collection(test1::all());
            return view('welcome', compact('test1'));
        }
    }
    public function showL()
    {
        return redirect('login');
    }
    public function showReg()
    {
        return redirect('register');;
    }
    public function showLog()
    {
        return view('login1');
    }
    public function showCreate()
    {
        $test1 = test1::all();
        return view('create', compact('test1'));
    }
    public function showUpd($itemId)
    {
        $test1 = test1::all();
        $test1Item = new JsonResource(test1::where('id', $itemId)->first());
        $page = 'upd1';
        return view('welcome', compact('test1','test1Item','page'));
    }
    public function add(test1Req $request)
    {
        test1::create($request->all());
        return redirect()->route('shw'); 
    }
    public function del($id)
    {
        if(Auth::user()->hasRole('admin'))
        {
            test1::where('id', $id)->delete();
            return redirect()->route('shw');
        }
        else
        {
            abort(403, 'Unauthorized action.'); 
        }
    }
    public function Upd($id, test1Req $req)
    {
        if(Auth::user()->hasRole('admin'))
        {
        test1::where('id', $id)->update(['name' => $req->input('name'), 'description' => $req->input('description')]);
        return redirect()->route('shw');
        }
        else
        {
            abort(403, 'Unauthorized action.'); 
        }
    }
}

