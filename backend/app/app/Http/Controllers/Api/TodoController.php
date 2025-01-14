<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {

        // http://localhost/ready/api.php/REST/v1/events

        $response = Http::withToken(Crypt::decryptString(auth()->user()->getAuthPassword()))
            ->withQueryParameters([
                                      '_sort' => '-evntid',
                                      '_limit' => 10,
                                  ])
            ->get('http://host.docker.internal/ready/api.php/REST/v1/events');

        $out = [];
        $todos = $response->json()['data'] ?? [];
        foreach ($todos as $todo) {
            $out[$todo['evntid']] = [
                'evntid' => $todo['evntid'],
                'description' => $todo['dscrpt'],
                'progress' => 0
            ];
        }

        $result = DB::table('todos')->select('progress')->whereIn('evntid', array_keys($out))->get();

        foreach ($result as $entry) {
            if (isset($evntids[$entry->evntid])) {
                $out[$entry->evntid]['progress'] = $entry->progress ?? 0;
            }
        }

        return response()->json([
                                    'status' => 'success',
                                    'todos' => array_values($out),
                                ]);
    }

    public function store(Request $request)
    {
        $request->validate([
                               'title' => 'required|string|max:255',
                               'description' => 'required|string|max:255',
                           ]);

        $todo = Todo::create([
                                 'title' => $request->title,
                                 'description' => $request->description,
                             ]);

        return response()->json([
                                    'status' => 'success',
                                    'message' => 'Todo created successfully',
                                    'todo' => $todo,
                                ]);
    }

    public function show($id)
    {
        $todo = Todo::find($id);
        return response()->json([
                                    'status' => 'success',
                                    'todo' => $todo,
                                ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                               'progress' => 'required|int'
                           ]);

        $todo = Todo::find($id);
        $todo->progress = $request->progress;
        $todo->save();

        return response()->json([
                                    'status' => 'success',
                                    'message' => 'Todo updated successfully',
                                    'todo' => $todo,
                                ]);
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();

        return response()->json([
                                    'status' => 'success',
                                    'message' => 'Todo deleted successfully',
                                    'todo' => $todo,
                                ]);
    }
}
