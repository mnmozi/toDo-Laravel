<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Task;
use JWTAuth;
class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function postTask(Request $request)
    {
        $task= new Task();
        $user=JWTAuth::toUser();
        $task->content = $request->input('content');//accese the body of my request
        $task->title = $request->input('title');
        $task->userid = $user->id;
        $task->save();
        return response()->json(['task'=>$task],201);
    }


    public function getTask()
    {
        $user=JWTAuth::toUser();
        $tasks = Task::where('userid',$user->id)->get();
        $response =['tasks' => $tasks];
        return response()->json($response,200);
    }

    
    public function putTask(Request $request, $id)
    {
        $task = Task::find($id);
        if(! $task)
        {
            return response()-> json(['message'=>'Task not found'],404);
        }
        $user=JWTAuth::toUser();
        if( $user->id != $task->userid)
        {
            return response()->json(['error'=>'This task is not yours'],200);
        }
        $task->content = $request->input('content');
        $task->title = $request->input('title');
       // $task->checked = $request->input('checked');
        $task->save();
        return response()->json(['task'=>$task],200);
    }


    public function deleteTask($id)
    {
        
        $task = Task::find($id);
        if(! $task)
        {
            return response()-> json(['message'=>'Task not found'],404);
        }
        $user=JWTAuth::toUser();
        if( $user->id != $task->userid)
        {
            return response()->json(['error'=>'This task is not yours'],200);
        }
        $task->delete();
        return response()->json(['message'=>'Task deleted'],200);
    }

    public function checkChangeTask($id)
    {
        $task = Task::find($id);
        if(! $task)
        {
            return response()-> json(['message'=>'Task not found'],404);
        }
        $user=JWTAuth::toUser();
        if( $user->id != $task->userid)
        {
            return response()->json(['error'=>'This task is not yours'],200);
        }
        $task->checked = !$task->checked;
        $task->save();
        return response()->json(['task'=>$task],200);
    }
}