<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function final_response($data = null, $message = '', $code = 200, $in_two_response = 'yes')
    {
        $postman_code = 200;
        if ($in_two_response == 'yes') {
            $postman_code = $code;
        }
        return response()->json([
            'data'    => $data,
            'message' => $message,
            'status'  => intval($code)
        ], $postman_code);
    }


    public function getMyTasks(Request $request){
        $userTasks = Task::where('user_id',$request->user_id)->get();
        return $this->final_response($userTasks, 'success', 200);
    }


    public function addTask(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'           => 'required|exists:users,id',
            'title'             => 'required|max:100',
            'des'               => 'required|max:200',

        ], [
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            return $this->final_response(collect($validator->errors())->flatten(1), 'failed', 422, 'yes');
        }
        $data = collect($validator->validated())->toArray();
        $task = Task::create($data);
        return $this->final_response($data, 'success', 200, 'yes');
    }



    public function updateTask(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'           => 'required|exists:users,id',
            'task_id'           => 'required|exists:tasks,id',
            'title'            => 'required|max:100',
            'des'        => 'required|max:200',

        ], [
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            return $this->final_response(collect($validator->errors())->flatten(1), 'failed', 422, 'yes');
        }
        $data = collect($validator->validated())->toArray();
        $task = Task::where('id',$request->task_id)->where('user_id',$request->user_id)->first();
        $task->update([
            'title'=>$request->title,
            'des'=>$request->des,
        ]);
        return $this->final_response($task, 'success', 200, 'yes');
    }


    public function updateTaskStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'           => 'required|exists:users,id',
            'task_id'           => 'required|exists:tasks,id',
            'status'            => 'required|in:finished,not_finished',

        ], [
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            return $this->final_response(collect($validator->errors())->flatten(1), 'failed', 422, 'yes');
        }
        $data = collect($validator->validated())->toArray();
        $task = Task::where('id',$request->task_id)->where('user_id',$request->user_id)->first();
        $task->update([
            'status'=>$request->status,
        ]);
        return $this->final_response($task, 'success', 200, 'yes');
    }



    public function deleteTask(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'           => 'required|exists:users,id',
            'task_id'           => 'required|exists:tasks,id',
        ], [
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            return $this->final_response(collect($validator->errors())->flatten(1), 'failed', 422, 'yes');
        }
        $data = collect($validator->validated())->toArray();
        $task = Task::where('id',$request->task_id)->where('user_id',$request->user_id)->where('status','finished')->first();
        $task->delete();
        return $this->final_response('Success Deleted Task', 'success', 200, 'yes');
    }



}
