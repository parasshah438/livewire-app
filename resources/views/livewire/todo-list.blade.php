<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-tasks me-2"></i>My Todo List
                        </h3>
                        <div class="d-flex gap-2">
                            <span class="badge bg-warning">{{ $pendingCount }} Pending</span>
                            <span class="badge bg-success">{{ $completedCount }} Completed</span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Todo Form -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $editingId ? 'Edit Todo' : 'Add New Todo' }}
                                    </h5>
                                    
                                    <form wire:submit.prevent="saveTodo">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="title" class="form-label">Title *</label>
                                                <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" 
                                                       id="title" placeholder="Enter todo title">
                                                @error('title') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label for="priority" class="form-label">Priority</label>
                                                <select wire:model="priority" class="form-select @error('priority') is-invalid @enderror" id="priority">
                                                    <option value="low">Low</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="high">High</option>
                                                </select>
                                                @error('priority') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label for="due_date" class="form-label">Due Date</label>
                                                <input type="datetime-local" wire:model="due_date" 
                                                       class="form-control @error('due_date') is-invalid @enderror" id="due_date">
                                                @error('due_date') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                            
                                            <div class="col-12">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" 
                                                          id="description" rows="3" placeholder="Enter todo description (optional)"></textarea>
                                                @error('description') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas {{ $editingId ? 'fa-save' : 'fa-plus' }} me-1"></i>
                                                        {{ $editingId ? 'Update Todo' : 'Add Todo' }}
                                                    </button>
                                                    
                                                    @if($editingId)
                                                        <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                                            <i class="fas fa-times me-1"></i>Cancel
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters and Sorting -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <button type="button" wire:click="setFilter('all')" 
                                        class="btn btn-outline-primary {{ $filter === 'all' ? 'active' : '' }}">
                                    All ({{ $pendingCount + $completedCount }})
                                </button>
                                <button type="button" wire:click="setFilter('pending')" 
                                        class="btn btn-outline-warning {{ $filter === 'pending' ? 'active' : '' }}">
                                    Pending ({{ $pendingCount }})
                                </button>
                                <button type="button" wire:click="setFilter('completed')" 
                                        class="btn btn-outline-success {{ $filter === 'completed' ? 'active' : '' }}">
                                    Completed ({{ $completedCount }})
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end gap-2">
                                <div class="btn-group" role="group">
                                    <button type="button" wire:click="setSorting('created_at')" 
                                            class="btn btn-outline-secondary {{ $sortBy === 'created_at' ? 'active' : '' }}">
                                        Date {{ $sortBy === 'created_at' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                                    </button>
                                    <button type="button" wire:click="setSorting('priority')" 
                                            class="btn btn-outline-secondary {{ $sortBy === 'priority' ? 'active' : '' }}">
                                        Priority {{ $sortBy === 'priority' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                                    </button>
                                    <button type="button" wire:click="setSorting('due_date')" 
                                            class="btn btn-outline-secondary {{ $sortBy === 'due_date' ? 'active' : '' }}">
                                        Due Date {{ $sortBy === 'due_date' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Todo List -->
                    <div class="row">
                        <div class="col-12">
                            @if($todos->count() > 0)
                                <div class="row g-3">
                                    @foreach($todos as $todo)
                                        <div class="col-12 col-md-6 col-lg-4" wire:key="todo-{{ $todo->id }}">
                                            <div class="card h-100 {{ $todo->completed ? 'border-success' : 'border-light' }} 
                                                        {{ $todo->priority === 'high' ? 'border-danger' : '' }}
                                                        {{ $todo->priority === 'medium' ? 'border-warning' : '' }}">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h6 class="card-title mb-0 {{ $todo->completed ? 'text-decoration-line-through text-muted' : '' }}">
                                                            {{ $todo->title }}
                                                        </h6>
                                                        <span class="badge bg-{{ $todo->priority === 'high' ? 'danger' : ($todo->priority === 'medium' ? 'warning' : 'secondary') }}">
                                                            {{ ucfirst($todo->priority) }}
                                                        </span>
                                                    </div>
                                                    
                                                    @if($todo->description)
                                                        <p class="card-text small {{ $todo->completed ? 'text-muted' : 'text-secondary' }}">
                                                            {{ Str::limit($todo->description, 100) }}
                                                        </p>
                                                    @endif
                                                    
                                                    @if($todo->due_date)
                                                        <p class="small mb-2">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            <span class="{{ $todo->due_date->isPast() && !$todo->completed ? 'text-danger fw-bold' : 'text-muted' }}">
                                                                Due: {{ $todo->due_date->format('M d, Y H:i') }}
                                                            </span>
                                                        </p>
                                                    @endif
                                                    
                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   wire:click="toggleComplete({{ $todo->id }})"
                                                                   {{ $todo->completed ? 'checked' : '' }}>
                                                            <label class="form-check-label small">
                                                                {{ $todo->completed ? 'Completed' : 'Mark Complete' }}
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button type="button" wire:click="editTodo({{ $todo->id }})" 
                                                                    class="btn btn-outline-primary btn-sm" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" wire:click="deleteTodo({{ $todo->id }})" 
                                                                    class="btn btn-outline-danger btn-sm" 
                                                                    onclick="return confirm('Are you sure you want to delete this todo?')" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="card-footer bg-transparent border-top-0">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Created {{ $todo->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-clipboard-list fa-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No todos found</h5>
                                    <p class="text-muted">
                                        @if($filter === 'pending')
                                            You don't have any pending todos. Great job!
                                        @elseif($filter === 'completed')
                                            You haven't completed any todos yet.
                                        @else
                                            Start by adding your first todo above.
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-hide alerts after 3 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000);
</script>
@endpush