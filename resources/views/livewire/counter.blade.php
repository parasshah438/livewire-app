<div class="card shadow border-0">
    <div class="card-header bg-primary text-white text-center">
        <h4 class="mb-0">
            <i class="fas fa-calculator me-2"></i>Livewire Counter
        </h4>
    </div>
    <div class="card-body text-center">
        {{-- 🎯 LESSON 1: Displaying public properties --}}
        <div class="mb-4">
            <span class="display-1 fw-bold text-primary">{{ $count }}</span>
        </div>

        {{-- 🎯 LESSON 2: wire:click calls component methods --}}
        <div class="d-flex justify-content-center gap-2 mb-4">
            <button wire:click="decrement" class="btn btn-danger">
                <i class="fas fa-minus me-1"></i>Decrease
            </button>
            <button wire:click="increment" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>Increase
            </button>
            <button wire:click="resetCounter" class="btn btn-secondary">
                <i class="fas fa-undo me-1"></i>Reset
            </button>
        </div>

    </div>
</div>
