<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\test1Req;
use App\Http\Requests\test1UpReq;
use App\Http\Requests\testLogA;
use App\Models\test1;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\elementsTest1;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use App\Models\permissionForElement;


class test1ApiCont extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return(JsonResource::collection(test1::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(test1Req $request)
    {
        $test1I = new test1();
        $test1I->name = $request->input('name');
        $test1I->description = $request->input('description');
        $test1I->user_id = Auth::user()->id;
        $test1I->save();
        return(JsonResource::collection(test1::all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new JsonResource(test1::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, test1Req $req)
    {
        test1::where('id', $id)->update(['name' => $req->input('name'), 'description' => $req->input('description')]);
        $item = new JsonResource(test1::where('id',$id)->first());
        return($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            test1::where('id', $id)->delete();
            return(JsonResource::collection(test1::all()));
    }
    public function logA(testLogA $req)
    {
        $user = User::where('email', $req->email)->first();
        if (Auth::guard('web')->validate([
            'email' => $req->email,
            'password' => $req->password,
        ]))
        {
            $token = $user->createToken($user->name)->plainTextToken;
            $user->assignRole('user');
            return($token);
        }
    }
    public function logoutA()
    {
        Auth::user()->removeRole('user');
        Auth::user()->tokens()->delete();
    }
    public function table($id)
    {
        $permissions = Auth::user()->getDirectPermissions();
        foreach($permissions as $permission)
        {
            if(!(elementsTest1::where('id', $id)->whereHas('permForElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->get()->isEmpty()))
            {
                $element = elementsTest1::where('id', $id)->whereHas('permForElem', function($q) use($permission){
                    $q->where('permission_id', $permission->id);
                })->get();
                return($element);
            }
            else if(!(elementsTest1::where('id', $id)->whereHas('mainElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->get()->isEmpty()))
            {
                $element = elementsTest1::where('id', $id)->whereHas('mainElem', function($q) use($permission){
                    $q->where('permission_id', $permission->id);
                })->with('subElem')->get();
                return($element);;
            }
            
        } 
    }
    public function storeElem(test1UpReq $req)
    {
        $elem = elementsTest1::create(['name' => $req->input('name'), 'parentId' => $req->input('parentId')]);
        $permissions = Auth::user()->getDirectPermissions();
        foreach($permissions as $permission)
        {
            permissionForElement::create(['element_id' => $elem->id, 'permission_id' => $permission->id]);
        }
    }
    public function destroyElem($id)
    {
        $permissions = Auth::user()->getDirectPermissions();
        foreach($permissions as $permission)
        {
            if(!(elementsTest1::where('id', $id)->whereHas('permForElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->get()->isEmpty()))
            {
                permissionForElement::where('element_id', $id)->delete();
                elementsTest1::where('id', $id)->delete();
            }
            
        }
    }
    public function updateElem($id, test1UpReq $req)
    {
        $permissions = Auth::user()->getDirectPermissions();
        foreach($permissions as $permission)
        {
            if(!(elementsTest1::where('id', $id)->whereHas('permForElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->get()->isEmpty()))
            {
                elementsTest1::where('id', $id)->update(['name' => $req->input('name'), 'parentId' => $req->input('parentId')]);
            }
            else if(!(elementsTest1::where('id', $id)->whereHas('mainElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->get()->isEmpty()))
            {
                elementsTest1::where('id', $id)->update(['name' => $req->input('name'), 'parentId' => $req->input('parentId')]);
            }
            
        } 
    }
    public function allElem()
    {
        Auth::user()->revokePermissionTo('mAll');
        $permissions = Auth::user()->getDirectPermissions();
        global $elementsWithPerm;
        foreach($permissions as $permission)
        {
            $items = elementsTest1::whereHas('mainElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->with('subElem')->get();
            foreach($items as $item)
            {
                $elementsWithPerm[] = $item;
            }
        }
        $elementsWithPerm = array_unique($elementsWithPerm);
        sort($elementsWithPerm);
        return($elementsWithPerm);
    }
}
