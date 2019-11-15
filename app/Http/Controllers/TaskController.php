<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(Task $task, Request $request)
    {
        $this->task = $task;
        $this->request = $request;
    }

    //todas as funções desse controler funcionam com apis
    public function selectAll()
    {
        if (isset(auth()->user()->id)) {
            $id_user = auth()->user()->id;
            $user_tasks = Task::where('id_user', $id_user)->where('done_at', NULL)->orderBy('created_at', 'desc')->get();
            return $user_tasks;
        }
        return '{
            "error":"Sem permissão para acesso"
        }';
    }

    public function selectFinish()
    {
        if (isset(auth()->user()->id)) {
            $id_user = auth()->user()->id;
            $user_tasks = Task::where('id_user', $id_user)->whereNotNull('done_at')->orderBy('created_at', 'desc')->get();
            return $user_tasks;
        }
        return '{
            "error":"Sem permissão para acesso"
        }';
    }

    public function update(Request $request)
    {

        if (isset(auth()->user()->id) === true) {

            $task = Task::find($request->id_task);
            $task->title = $request->title;
            $task->description = $request->description;
            $task->updated_at = Carbon::now();
            $task->save();

            return redirect('home');
        } else {
            return '{
                "error":"Sem permissão para acesso"
            }';
        }
    }

    public function create(Request $request)
    {

        if (isset(auth()->user()->id) === true) {

            $user_id = auth()->user()->id;
            $task = new Task;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->id_user = $user_id;
            $task->created_at = Carbon::now();
            $task->save();

            return redirect('home');
        } else {
            return '{
                "error":"Sem permissão para acesso"
            }';
        }
    }

    public function alterStatus($id_task)
    {
        if (isset(auth()->user()->id) === true) {

            $task = Task::find($id_task);

            if ($task->id_user == auth()->user()->id) {

                    $task->done_at = Carbon::now();
                    $task->save();

                    return redirect('home');

            } else {

                return '{
                    "error":"Operação ilegal"
                }';
            }

            return $task;
        } else {

            return '{
                "error":"Sem permissão para acesso"
            }';
        }
    }

    public function delet($id_task)
    {
        if (isset(auth()->user()->id) === true) {

            $delet = Task::findorfail($id_task);

            if ($delet->id_user == auth()->user()->id) {

                $delet->delete();
            } else {

                return '{
                    "error":"Operação ilegal"
                }';
            }

            return $delet;
        } else {

            return '{
                "error":"Sem permissão para acesso"
            }';
        }
    }
}
