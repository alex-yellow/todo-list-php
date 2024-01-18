<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Priority;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private function checkUserAuth()
    {
        $user = session('user');
        if(!$user){
            redirect('/login')->send();
            exit();
        }
        return $user;
    }

    public function index(Request $request)
    {
        $user = $this->checkUserAuth();

        $categories = Category::all();
        $priorities = Priority::all();
        $query = Task::query()->where('user_id', $user['id']);

        // Поиск по названию, учитывая совпадение хотя бы двух букв
        if($request->has('search')){
            $searchTask = $request->input('search');
            $query->where('title', 'LIKE', '%' . $searchTask . '%');
        }
        // Фильтрация по категории
        if($request->has('category_id')){
            $selectedCategory = $request->input('category_id');
            $query->where('category_id', $selectedCategory);
        }
        // Фильтрация по приоритету
        if($request->has('priority_id')){
            $selectedPriority = $request->input('priority_id');
            $query->where('priority_id', $selectedPriority);
        }
        $tasks = $query->orderBy('id', 'desc')->paginate(5);

        return view('task.index', compact('tasks', 'categories', 'priorities'));
    }

    public function create()
    {
        $user = $this->checkUserAuth();
        $categories = Category::all();
        $priorities = Priority::all();
        return view('task.create', compact('categories', 'priorities'));
    }

    public function store(Request $request)
    {
        $user = $this->checkUserAuth();

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'priority_id' => 'required'
        ]);

        $task = Task::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'priority_id' => $request->priority_id,
            'user_id' => $user['id'],
        ]);

        return redirect()->route('task.index')->with('success', 'Task add success');
    }

    public function edit(Task $task)
    {
        $user = $this->checkUserAuth();

        $categories = Category::all();
        $priorities = Priority::all();
        return view('task.edit', compact('task','categories', 'priorities'));
    }

    public function update(Request $request, Task $task)
    {
        $user = $this->checkUserAuth();

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'priority_id' => 'required'
        ]);

        $task->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'priority_id' => $request->priority_id,
        ]);

        return redirect()->route('task.index')->with('success', 'Task edit success');
    }

    public function delete(Task $task)
    {
        $user = $this->checkUserAuth();

        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task delete success');

    }

    public function complete(Task $task)
    {
        $user = $this->checkUserAuth();

        $task->completed = !$task->completed;
        $task->save();

        return redirect()->route('task.index')->with('success', 'Task complete success');

    }
}
