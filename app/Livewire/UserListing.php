<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class UserListing extends Component
{
    use WithPagination, WithFileUploads;

    // Search and Filter Properties
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    // UI State
    public $showFilters = false;
    public $selectedUsers = [];
    public $selectAll = false;

    // Edit User Modal Properties
    public $showEditModal = false;
    public $editUserId = null;
    public $editName = '';
    public $editEmail = '';
    public $editProfilePhoto;
    public $resetPassword = false;

    // Advanced Search Properties
    public $searchBy = 'all';
    public $dateFrom = '';
    public $dateTo = '';
    public $sortOptions = [
        'name' => 'Name',
        'email' => 'Email', 
        'created_at' => 'Date Created',
        'updated_at' => 'Last Updated'
    ];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'editName' => 'required|string|max:255',
        'editEmail' => 'required|email|max:255',
        'editProfilePhoto' => 'nullable|image|max:1024',
    ];

    protected $messages = [
        'editName.required' => 'Name is required.',
        'editEmail.required' => 'Email is required.',
        'editEmail.email' => 'Please enter a valid email address.',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        // Reset pagination when component mounts
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            // Toggle direction if same field
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // New field, default to ascending
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->searchBy = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->sortBy = 'created_at';
        $this->sortDirection = 'desc';
        $this->perPage = 10;
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedUsers = $this->users->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function updatedSelectedUsers()
    {
        $this->selectAll = count($this->selectedUsers) === $this->users->count();
    }

    public function deleteSelected()
    {
        if (count($this->selectedUsers) > 0) {
            // Don't allow deleting the current user
            $currentUserId = Auth::id();
            $usersToDelete = array_filter($this->selectedUsers, function($id) use ($currentUserId) {
                return $id != $currentUserId;
            });

            if (count($usersToDelete) > 0) {
                User::whereIn('id', $usersToDelete)->delete();
                session()->flash('message', count($usersToDelete) . ' user(s) deleted successfully.');
                $this->dispatch('show-toast', ['type' => 'success', 'message' => count($usersToDelete) . ' user(s) deleted successfully!']);
                $this->selectedUsers = [];
                $this->selectAll = false;
            } else {
                session()->flash('error', 'Cannot delete your own account.');
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Cannot delete your own account.']);
            }
        }
    }

    public function editUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->editUserId = $userId;
            $this->editName = $user->name;
            $this->editEmail = $user->email;
            $this->editProfilePhoto = null;
            $this->resetPassword = false;
            $this->showEditModal = true;
            $this->resetValidation();
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editUserId = null;
        $this->editName = '';
        $this->editEmail = '';
        $this->editProfilePhoto = null;
        $this->resetPassword = false;
        $this->resetValidation();
    }

    public function updateUser()
    {
        // Custom validation for unique email (excluding current user)
        $this->validate([
            'editName' => 'required|string|max:255',
            'editEmail' => 'required|email|max:255|unique:users,email,' . $this->editUserId,
        ]);

        $user = User::find($this->editUserId);
        if ($user) {
            // Handle profile photo upload
            if ($this->editProfilePhoto) {
                // Delete old profile photo if exists
                if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                    Storage::disk('public')->delete($user->profile_photo);
                }
                
                // Store new profile photo
                $photoPath = $this->editProfilePhoto->store('profile-photos', 'public');
                $user->profile_photo = $photoPath;
            }

            $user->name = $this->editName;
            $user->email = $this->editEmail;
            
            // Reset password if requested
            if ($this->resetPassword) {
                $user->password = Hash::make('password123');
            }
            
            $user->save();
            
            session()->flash('message', 'User updated successfully.');
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'User updated successfully!']);
            $this->closeEditModal();
        }
    }

    public function deleteUser($userId)
    {
        // Don't allow deleting the current user
        if ($userId == Auth::id()) {
            session()->flash('error', 'Cannot delete your own account.');
            return;
        }

        $user = User::find($userId);
        if ($user) {
            $userName = $user->name;
            $user->delete();
            session()->flash('message', 'User "' . $userName . '" deleted successfully.');
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'User "' . $userName . '" deleted successfully!']);
            
            // Remove from selected users if it was selected
            $this->selectedUsers = array_filter($this->selectedUsers, function($id) use ($userId) {
                return $id != $userId;
            });
        }
    }

    public function exportCsv()
    {
        $users = $this->getFilteredUsersQuery()->get();
        
        $csvData = "ID,Name,Email,Created At\n";
        
        foreach ($users as $user) {
            $csvData .= "{$user->id},{$user->name},{$user->email},{$user->created_at->format('Y-m-d H:i:s')}\n";
        }
        
        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, 'users-' . date('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users-' . date('Y-m-d') . '.csv"',
        ]);
    }

    public function exportSelected()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'Please select users to export.');
            return;
        }

        $users = User::whereIn('id', $this->selectedUsers)->get();
        
        $csvData = "ID,Name,Email,Created At\n";
        
        foreach ($users as $user) {
            $csvData .= "{$user->id},{$user->name},{$user->email},{$user->created_at->format('Y-m-d H:i:s')}\n";
        }
        
        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, 'selected-users-' . date('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="selected-users-' . date('Y-m-d') . '.csv"',
        ]);
    }

    private function getFilteredUsersQuery()
    {
        return User::query()
            ->when($this->search, function ($query) {
                if ($this->searchBy === 'all') {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                } elseif ($this->searchBy === 'name') {
                    $query->where('name', 'like', '%' . $this->search . '%');
                } elseif ($this->searchBy === 'email') {
                    $query->where('email', 'like', '%' . $this->search . '%');
                }
            })
            ->when($this->dateFrom, function ($query) {
                $query->where('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->where('created_at', '<=', $this->dateTo . ' 23:59:59');
            })
            ->orderBy($this->sortBy, $this->sortDirection);
    }

    public function getUsersProperty()
    {
        return $this->getFilteredUsersQuery()->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.user-listing', [
            'users' => $this->users
        ])->layout('layouts.app-livewire');
    }
}
