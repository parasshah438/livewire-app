<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;

class TodoList extends Component
{
    #[Rule('required|string|max:255')]
    public $title = '';

    #[Rule('nullable|string|max:1000')]
    public $description = '';

    #[Rule('required|in:low,medium,high')]
    public $priority = 'medium';

    #[Rule('nullable|date|after:now')]
    public $due_date = '';

    public $editingId = null;
    public $filter = 'all'; // all, pending, completed
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        $query = Todo::where('user_id', Auth::id());

        // Apply filters
        if ($this->filter === 'pending') {
            $query->pending();
        } elseif ($this->filter === 'completed') {
            $query->completed();
        }

        // Apply sorting
        $todos = $query->orderBy($this->sortBy, $this->sortDirection)->get();

        return view('livewire.todo-list', [
            'todos' => $todos,
            'pendingCount' => Todo::where('user_id', Auth::id())->pending()->count(),
            'completedCount' => Todo::where('user_id', Auth::id())->completed()->count(),
        ]);
    }

    public function saveTodo()
    {
        $this->validate();

        if ($this->editingId) {
            // Update existing todo
            $todo = Todo::findOrFail($this->editingId);
            $todo->update([
                'title' => $this->title,
                'description' => $this->description,
                'priority' => $this->priority,
                'due_date' => $this->due_date ?: null,
            ]);
            
            session()->flash('message', 'Todo updated successfully!');
        } else {
            // Create new todo
            Todo::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'description' => $this->description,
                'priority' => $this->priority,
                'due_date' => $this->due_date ?: null,
            ]);
            
            session()->flash('message', 'Todo created successfully!');
        }

        $this->resetForm();
    }

    public function editTodo($id)
    {
        $todo = Todo::findOrFail($id);
        
        $this->editingId = $id;
        $this->title = $todo->title;
        $this->description = $todo->description;
        $this->priority = $todo->priority;
        $this->due_date = $todo->due_date ? $todo->due_date->format('Y-m-d\TH:i') : '';
    }

    public function deleteTodo($id)
    {
        Todo::findOrFail($id)->delete();
        session()->flash('message', 'Todo deleted successfully!');
    }

    public function toggleComplete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update(['completed' => !$todo->completed]);
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->description = '';
        $this->priority = 'medium';
        $this->due_date = '';
        $this->resetErrorBag();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function setSorting($sortBy)
    {
        if ($this->sortBy === $sortBy) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $sortBy;
            $this->sortDirection = 'asc';
        }
    }
}