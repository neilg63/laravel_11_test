<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function index(Request $request) {
        $users = User::all();
        
        return response()->json([
            'users'     => $users,        
        ]);
    }

    public function show(Request $request, User $user) {
        $exists = $user instanceof User;
        $result = ['exists' => $exists];
        $status = $exists ? 200 : 404;
        if ($exists) {
            $result['user'] = $user;
        }
        return response()->json($result, $status);
    }

    public function create(Request $request) {
        $payload = $request->json()->all();
        $valid = false;
        $user = null;
        $validator = Validator::make($payload, [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255|email',
            'password' => 'required',
        ]);
       if ($validator->fails()) {
        return response()->json([
            'params' => $payload,
            'valid'     => $valid,
        ], 406);
        } else {
            $validated = $validator->safe()->only(['name','email','password']);
            if (count($validated) > 2) {
                $user = User::create($validated);
                $valid = $user instanceof User;
            }
            return response()->json([
                'user'     => $user,
                'valid'     => $valid,
            ]);
       }
    }


    public function update(Request $request, int $id = 0) {
        $payload = $request->json()->all();
        $updateable = false;
        $user = $id > 0 ? User::find($id) : null;
        if ($user instanceof User && count($payload) > 0) {
            foreach ($payload as $key => $value) {
                if ($user->hasAttribute($key)) {
                    if ($value !== $user->{$key}) {
                        $user->{$key} = $value;
                        $updateable = true;
                    }
                }
            }
            if ($updateable) {
                $user->save();
            }
        }
        

        return response()->json([
            'id' => $id,
            'user'     => $user,
            'updated' => $updateable,
        ]);
    }

    public function setStatus(Request $request, int $id = 0) {
        $hasActiveFlag = $request->json()->has('active');
        $active = $hasActiveFlag ? $request->json()->get('active') : false;
        $result = ['id' => $id, 'exists' => false];
        if ($id > 0 && $hasActiveFlag) {
            $result = User::updateActive($id, $active);
        }
        return response()->json($result);
    }

    public function destroy(Request $request, int $id = 0) {
        $user = $id > 0 ? User::find($id) : null;
        $status = 404;
        $hasUser = $user instanceof User;
        $result = ['id' => $id, 'exists' => false,'deleted' => false];
        if ($id > 0 && $hasUser) {
            $user->delete();
            $status = 200;
            $result['exists'] = true;
            $result['deleted'] = true;
        }
        return response()->json($result, $status);
    }
}
