<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
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
                                      '_sort' => 'evntid',
                                      '_limit' => 10,
                                  ])
            ->get('http://host.docker.internal/ready/api.php/REST/v1/events');

        print_r($response->json());

        die();

        $todos = Todo::all();
        return response()->json([
                                    'status' => 'success',
                                    'todos' => $todos,
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
                               'title' => 'required|string|max:255',
                               'description' => 'required|string|max:255',
                           ]);

        $todo = Todo::find($id);
        $todo->title = $request->title;
        $todo->description = $request->description;
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
