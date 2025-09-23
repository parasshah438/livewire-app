<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Header -->
                <div class="profile-card p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="text-white mb-0">
                                <i class="fas fa-users me-3"></i>User Management
                            </h2>
                            <p class="text-white-75 mb-0">
                                Manage and organize system users
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group me-2" role="group">
                                <button 
                                    class="btn btn-info"
                                    wire:click="exportCsv"
                                    title="Export All Users"
                                >
                                    <i class="fas fa-download me-2"></i>Export CSV
                                </button>
                                @if(count($selectedUsers) > 0)
                                    <button 
                                        class="btn btn-success"
                                        wire:click="exportSelected"
                                        title="Export Selected Users"
                                    >
                                        <i class="fas fa-file-export me-2"></i>Export Selected
                                    </button>
                                @endif
                            </div>
                            
                            <button 
                                class="btn btn-secondary-gradient me-2"
                                wire:click="toggleFilters"
                            >
                                <i class="fas fa-filter me-2"></i>
                                {{ $showFilters ? 'Hide Filters' : 'Show Filters' }}
                            </button>
                            
                            @if(count($selectedUsers) > 0)
                                <button 
                                    class="btn btn-danger"
                                    wire:click="deleteSelected"
                                    wire:confirm="Are you sure you want to delete the selected users?"
                                >
                                    <i class="fas fa-trash me-2"></i>Delete Selected ({{ count($selectedUsers) }})
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if (session('message'))
                    <div class="alert alert-success-custom d-flex align-items-center mb-4" role="alert">
                        <div class="alert-icon me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading mb-1">Success!</h6>
                            <p class="mb-0">{{ session('message') }}</p>
                        </div>
                        <button type="button" class="btn-close btn-close-white ms-3" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <!-- Filters Panel -->
                @if($showFilters)
                    <div class="profile-card p-4 mb-4">
                        <h5 class="text-white mb-3">
                            <i class="fas fa-search me-2"></i>Search & Filters
                        </h5>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="search" class="form-label">
                                    <i class="fas fa-search me-2"></i>Search Users
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="search"
                                    wire:model.live.debounce.300ms="search"
                                    placeholder="Search users..."
                                >
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="searchBy" class="form-label">
                                    <i class="fas fa-filter me-2"></i>Search In
                                </label>
                                <select class="form-select" id="searchBy" wire:model.live="searchBy">
                                    <option value="all">All Fields</option>
                                    <option value="name">Name Only</option>
                                    <option value="email">Email Only</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="dateFrom" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>From Date
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="dateFrom"
                                    wire:model.live="dateFrom"
                                >
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="dateTo" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>To Date
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="dateTo"
                                    wire:model.live="dateTo"
                                >
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="sortBy" class="form-label">
                                    <i class="fas fa-sort me-2"></i>Sort By
                                </label>
                                <select class="form-select" id="sortBy" wire:model.live="sortBy">
                                    <option value="name">Name</option>
                                    <option value="email">Email</option>
                                    <option value="created_at">Date Created</option>
                                    <option value="updated_at">Last Updated</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="sortDirection" class="form-label">
                                    <i class="fas fa-arrows-alt-v me-2"></i>Direction
                                </label>
                                <select class="form-select" id="sortDirection" wire:model.live="sortDirection">
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="perPage" class="form-label">
                                    <i class="fas fa-list me-2"></i>Per Page
                                </label>
                                <select class="form-select" id="perPage" wire:model.live="perPage">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="col-md-1 mb-3 d-flex align-items-end">
                                <button 
                                    class="btn btn-outline-light btn-sm w-100"
                                    wire:click="clearFilters"
                                    title="Clear Filters"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Users Table -->
                <div class="profile-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-table me-2"></i>Users List
                            <span class="badge bg-primary ms-2">{{ $users->total() }} Total</span>
                        </h5>
                        @if($search)
                            <small class="text-white-75">
                                <i class="fas fa-search me-1"></i>Searching for: "{{ $search }}"
                            </small>
                        @endif
                    </div>

                    <!-- Loading State -->
                    <div wire:loading.delay class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-white-75 mt-2">Loading users...</p>
                    </div>

                    <!-- Users Table -->
                    <div wire:loading.remove class="table-responsive">
                        @if($users->count() > 0)
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    wire:model.live="selectAll"
                                                    wire:click="toggleSelectAll"
                                                >
                                            </div>
                                        </th>
                                        <th scope="col" wire:click="sortBy('name')" style="cursor: pointer;">
                                            <i class="fas fa-user me-2"></i>Name
                                            @if($sortBy === 'name')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="sortBy('email')" style="cursor: pointer;">
                                            <i class="fas fa-envelope me-2"></i>Email
                                            @if($sortBy === 'email')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="sortBy('created_at')" style="cursor: pointer;">
                                            <i class="fas fa-calendar me-2"></i>Joined
                                            @if($sortBy === 'created_at')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @endif
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-cog me-2"></i>Status
                                        </th>
                                        <th scope="col" width="150">
                                            <i class="fas fa-tools me-2"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr class="{{ in_array($user->id, $selectedUsers) ? 'table-active' : '' }}">
                                            <td>
                                                <div class="form-check">
                                                    <input 
                                                        class="form-check-input" 
                                                        type="checkbox" 
                                                        wire:model.live="selectedUsers"
                                                        value="{{ $user->id }}"
                                                    >
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-3">
                                                        <img 
                                                            src="{{ $user->profile_photo_url }}" 
                                                            alt="{{ $user->name }}"
                                                            class="rounded-circle"
                                                            width="40" 
                                                            height="40"
                                                            style="object-fit: cover; border: 2px solid rgba(255,255,255,0.2);"
                                                        >
                                                    </div>
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        @if($user->id === auth()->id())
                                                            <span class="badge bg-success ms-2">You</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-white-75">{{ $user->email }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <small class="text-white-75">
                                                        {{ $user->created_at->format('M d, Y') }}
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $user->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Active
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button 
                                                        class="btn btn-sm btn-warning"
                                                        wire:click="editUser({{ $user->id }})"
                                                        title="Edit User"
                                                    >
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if($user->id !== auth()->id())
                                                        <button 
                                                            class="btn btn-sm btn-danger"
                                                            wire:click="deleteUser({{ $user->id }})"
                                                            wire:confirm="Are you sure you want to delete {{ $user->name }}? This action cannot be undone."
                                                            title="Delete User"
                                                        >
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-4x text-white-75 mb-3"></i>
                                <h5 class="text-white mb-2">No Users Found</h5>
                                <p class="text-white-75">
                                    @if($search)
                                        No users match your search criteria.
                                    @else
                                        There are no users in the system.
                                    @endif
                                </p>
                                @if($search)
                                    <button class="btn btn-outline-light btn-sm" wire:click="clearFilters">
                                        <i class="fas fa-times me-2"></i>Clear Search
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-white-75">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Edit User Modal -->
                @if($showEditModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <div class="modal-header border-bottom border-secondary">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-user-edit me-2"></i>Edit User
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeEditModal"></button>
                    </div>
                    <form wire:submit.prevent="updateUser">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editName" class="form-label text-white">Name</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="editName"
                                    wire:model="editName"
                                    style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white;"
                                >
                                @error('editName') 
                                    <div class="text-danger mt-1">{{ $message }}</div> 
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label text-white">Email</label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="editEmail"
                                    wire:model="editEmail"
                                    style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white;"
                                >
                                @error('editEmail') 
                                    <div class="text-danger mt-1">{{ $message }}</div> 
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="editProfilePhoto" class="form-label text-white">Profile Photo</label>
                                <input 
                                    type="file" 
                                    class="form-control" 
                                    id="editProfilePhoto"
                                    wire:model="editProfilePhoto"
                                    accept="image/*"
                                    style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white;"
                                >
                                @error('editProfilePhoto') 
                                    <div class="text-danger mt-1">{{ $message }}</div> 
                                @enderror
                                
                                @if ($editProfilePhoto)
                                    <div class="mt-2">
                                        <small class="text-white-75">Photo Preview:</small>
                                        <div class="d-flex align-items-center mt-1">
                                            <img src="{{ $editProfilePhoto->temporaryUrl() }}" class="rounded" width="50" height="50" style="object-fit: cover;">
                                            <span class="text-white ms-2">{{ $editProfilePhoto->getClientOriginalName() }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    id="resetPassword" 
                                    wire:model="resetPassword"
                                >
                                <label class="form-check-label text-white" for="resetPassword">
                                    Reset password to default (password123)
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer border-top border-secondary">
                            <button type="button" class="btn btn-secondary" wire:click="closeEditModal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
                @endif

                <!-- Toast Notifications -->
    <div class="toast-container">
        @if (session('message'))
            <div class="toast toast-success show" role="alert">
                <div class="toast-header bg-transparent border-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <strong class="me-auto text-white">Success</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body text-white">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div class="toast toast-error show" role="alert">
                <div class="toast-header bg-transparent border-0">
                    <i class="fas fa-exclamation-circle text-danger me-2"></i>
                    <strong class="me-auto text-white">Error</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body text-white">
                    {{ session('error') }}
                </div>
            </div>
        @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
        .table-dark {
            --bs-table-bg: rgba(255, 255, 255, 0.05);
            --bs-table-border-color: rgba(255, 255, 255, 0.1);
        }
        
        .table-dark th {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-weight: 600;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .table-hover > tbody > tr:hover > td {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .table-active {
            background: rgba(0, 123, 255, 0.2) !important;
        }
        
        .avatar-circle {
            transition: transform 0.2s ease;
        }
        
        .avatar-circle:hover {
            transform: scale(1.1);
        }
        
        .pagination .page-link {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .pagination .page-link:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
        }
        
        .pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        
        /* Fix for select dropdowns in filters */
        .form-select {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            backdrop-filter: blur(10px);
        }
        
        .form-select:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
            color: white !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1) !important;
        }
        
        .form-select option {
            background: rgba(0, 0, 0, 0.8) !important;
            color: white !important;
        }
        
        .form-select:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
        
        /* Action buttons styling */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
        }
        
        /* Modal styling enhancements */
        .modal-content {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
        }
        
        .modal-content .form-control:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
            color: white !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1) !important;
        }
        
        .modal-content .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff8800 100%);
            border: none;
            color: #000;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #ff8800 0%, #ffc107 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
        }
        
        /* Date input styling */
        .form-control[type="date"] {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }
        
        .form-control[type="date"]:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
            color: white !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1) !important;
        }
        
        .form-control[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
        
        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }
        
        .toast-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
        }
        
        .toast-error {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
            border: none;
            color: white;
        }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide toasts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(function(toast) {
            setTimeout(function() {
                toast.classList.remove('show');
            }, 5000);
        });
    });
    
    // Listen for Livewire events
    document.addEventListener('livewire:init', () => {
        Livewire.on('show-toast', (event) => {
            const toastContainer = document.querySelector('.toast-container');
            const toastHtml = `
                <div class="toast ${event.type === 'success' ? 'toast-success' : 'toast-error'} show" role="alert">
                    <div class="toast-header bg-transparent border-0">
                        <i class="fas fa-${event.type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
                        <strong class="me-auto text-white">${event.type === 'success' ? 'Success' : 'Error'}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body text-white">
                        ${event.message}
                    </div>
                </div>
            `;
            toastContainer.innerHTML = toastHtml;
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                const toast = toastContainer.querySelector('.toast');
                if (toast) toast.classList.remove('show');
            }, 5000);
        });
    });
</script>
@endpush
