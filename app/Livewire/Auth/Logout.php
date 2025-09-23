<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout extends Component
{
    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
        
        session()->flash('message', 'You have been successfully logged out.');
        
        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return <<<'blade'
            <button wire:click="logout" class="btn btn-link text-decoration-none text-start w-100 p-2" style="color: #212529;">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
        blade;
    }
}
