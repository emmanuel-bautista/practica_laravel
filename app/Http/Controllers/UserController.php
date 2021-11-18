<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('task')->get();

        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validated = $userFormRequest->validated();
        $validator = Validator::make([
            'name' =>  $request['name'],
            'email' =>  $request['email'],
            'password' =>  $request['password'],
            'birth_date' =>  $request['birth_date'],
            'password_confirmation' => $request['password_confirmation']
        ], [
            'email' => 'required|email|unique:users|string',
            'name' => 'required|string|max:45',
            'birth_date' => 'required|string|max:10',
            'password' => 'required',
            'password_confirmation' => 'same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            'name' =>  $request['name'],
            'email' =>  $request['email'],
            'password' =>  $request['password'],
            'birth_date' =>  $request['birth_date'],
        ]);

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make([
            'birth_date' =>  $request['birth_date'],
            'task_id' =>  $request['task_id'],
        ], [
            'birth_date' => 'required|string|max:10',
            'task_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $user = User::find($id);
        $user->birth_date =  $request['birth_date'];
        $user->save();

        $task = Task::find($request['task_id']);

        if ($task) {
            $task->user_id = $user->id;
        }


        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message' => "User with id $id was deleted"
        ]);
    }
}
