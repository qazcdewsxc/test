<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * Display all elements.
     */
    public function allElem()
    {
        $permissions = Auth::user()->getAllPermissions();
        $elementsWithPerm;
        foreach($permissions as $permission)
        {
            $items = elementsTest1::whereHas('mainElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->with('childs')->get();
            foreach($items as $item)
            {
                $elementsWithPerm[] = $item;
            }
            $items = elementsTest1::whereHas('permForElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->whereHas('childs')->with('childs')->get();
            foreach($items as $item)
            {
                $elementsWithPerm[] = $item;
            }
            $items = elementsTest1::whereHas('permForElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->where('parentId', NULL)->with('childs')->get();
            foreach($items as $item)
            {
                $elementsWithPerm[] = $item;
            }
        }
        $elementsWithPerm = array_unique($elementsWithPerm);
        sort($elementsWithPerm);
        return($elementsWithPerm);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeElem(test1UpReq $req)
    {
        $elem = elementsTest1::create(['name' => $req->input('name'), 'parentId' => $req->input('parentId')]);
        $permissions = Auth::user()->getAllPermissions();
        foreach($permissions as $permission)
        {
            permissionForElement::create(['element_id' => $elem->id, 'permission_id' => $permission->id]);
        }
        return($elem);
    }
    /**
     * Display the specified resource.
     */
    public function table($id)
    {
        $permissions = Auth::user()->getAllPermissions();
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
                })->with('childs')->get();
                return($element);;
            }
            
        }
        return('No access');
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateElem($id, test1UpReq $req)
    {
        $permissions = Auth::user()->getAllPermissions();
        foreach($permissions as $permission)
        {
            if(!(elementsTest1::where('id', $id)->whereHas('permForElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->get()->isEmpty()))
           {
                elementsTest1::where('id', $id)->update(['name' => $req->input('name'), 'parentId' => $req->input('parentId')]);
                return(elementsTest1::where('id', $id)->first());
            }
            else if(!(elementsTest1::where('id', $id)->whereHas('mainElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->get()->isEmpty()))
            {
                elementsTest1::where('id', $id)->update(['name' => $req->input('name'), 'parentId' => $req->input('parentId')]);
                return(elementsTest1::where('id', $id)->with('childs')->get());
            }
            
        }
        return('fail');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroyElem($id)
    {
        $permissions = Auth::user()->getAllPermissions();
        foreach($permissions as $permission)
        {
            if(!(elementsTest1::where('id', $id)->whereHas('permForElem', function($q) use($permission){
                $q->where('permission_id', $permission->id);
            })->get()->isEmpty()))
            {
                permissionForElement::where('element_id', $id)->delete();
                elementsTest1::where('id', $id)->delete();
                return('Object deleted successfully');
            }
            
        }
        return('fail');
    }
    /**
     * Login
     */
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
            return[
                'Token'=>$token];
        }
    }
    /**
     * Logout
     */
    public function logoutA()
    {
        Auth::user()->removeRole('user');
        Auth::user()->tokens()->delete();
    }
}