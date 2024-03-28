<?php

namespace App\Http\Controllers;

use App\Http\Services\HttpResponseService;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function add(Request $req)
    {
        $task = new Task;
        $task->nome = $req->nome;
        $task->descricao = $req->descricao;
        $task->horario = $req->horario;
        $task->save();
        return HttpResponseService::created('add ok', $task);
    }

    public function list()
    {
        $tasks = Task::all();
        return HttpResponseService::success('list ok', $tasks);
    }

    public function read($id)
    {
        $task = $this->find($id);
        return HttpResponseService::success('read ok', $task);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nome' => 'string',
            'descricao' => 'string',
            'horario'=> 'string'
        ]);
        $task = $this->find($id);
        $task->fill($request->all());
        $task->save();
        return HttpResponseService::success('edit ok', $task);
    }

    private function find($id)
    {
        try {
            return Task::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404, 'not found');
        }
    }

    public function delete($id)
    {
        $task = $this->find($id);
        $task->delete();
        return HttpResponseService::success('delete ok', $task->id);
    }
}
