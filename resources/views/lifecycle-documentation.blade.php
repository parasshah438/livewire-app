<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire 3 Component Lifecycle Documentation</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Prism.js for syntax highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    
    <style>
        .lifecycle-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }
        .lifecycle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .mount-card { border-left-color: #28a745; }
        .updated-card { border-left-color: #ffc107; }
        .render-card { border-left-color: #17a2b8; }
        .hydrate-card { border-left-color: #6c757d; }
        
        .flow-diagram {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .flow-step {
            background: white;
            border-radius: 15px;
            padding: 15px;
            margin: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .flow-step:hover {
            transform: scale(1.05);
        }
        
        .arrow {
            font-size: 2rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .code-example {
            background: #2d3748;
            color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .section-divider {
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
            border: none;
            margin: 3rem 0;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #667eea, #764ba2);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 10px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #667eea;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #667eea;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark gradient-bg shadow-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-book-open me-2"></i>📚 Livewire 3 Lifecycle Documentation
            </a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('counter') }}" class="nav-link">
                    <i class="fas fa-calculator me-1"></i>Counter Demo
                </a>
                <a href="{{ route('lifecycle') }}" class="nav-link">
                    <i class="fas fa-cogs me-1"></i>Interactive Lifecycle
                </a>
                <a href="{{ route('user-profile') }}" class="nav-link">
                    <i class="fas fa-user me-1"></i>User Profile
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-sync-alt me-3"></i>Livewire 3 Component Lifecycle
            </h1>
            <p class="lead">Master the complete lifecycle of Livewire components with detailed explanations, code examples, and visual diagrams</p>
        </div>
    </section>

    <!-- Quick Navigation -->
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-compass me-2 text-primary"></i>Quick Navigation
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#overview" class="btn btn-outline-primary btn-sm">Overview</a>
                            <a href="#flow-diagram" class="btn btn-outline-primary btn-sm">Flow Diagram</a>
                            <a href="#methods" class="btn btn-outline-primary btn-sm">Lifecycle Methods</a>
                            <a href="#examples" class="btn btn-outline-primary btn-sm">Code Examples</a>
                            <a href="#best-practices" class="btn btn-outline-primary btn-sm">Best Practices</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Section -->
    <section id="overview" class="container my-5">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-4">
                    <i class="fas fa-eye me-2 text-primary"></i>Lifecycle Overview
                </h2>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <p class="lead text-center mb-4">
                            Livewire components follow a predictable lifecycle from initialization to destruction. 
                            Understanding this flow is crucial for building efficient, reactive applications.
                        </p>
                        
                        <div class="row g-4">
                            <div class="col-md-3 text-center">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-play fa-2x text-success"></i>
                                </div>
                                <h6 class="mt-3">Initialization</h6>
                                <small class="text-muted">Component starts</small>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-sync-alt fa-2x text-warning"></i>
                                </div>
                                <h6 class="mt-3">Updates</h6>
                                <small class="text-muted">Properties change</small>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-paint-brush fa-2x text-info"></i>
                                </div>
                                <h6 class="mt-3">Rendering</h6>
                                <small class="text-muted">View updates</small>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-exchange-alt fa-2x text-secondary"></i>
                                </div>
                                <h6 class="mt-3">State Transfer</h6>
                                <small class="text-muted">Hydration cycle</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="section-divider">

    <!-- Flow Diagram Section -->
    <section id="flow-diagram" class="my-5">
        <div class="container">
            <h2 class="text-center mb-5">
                <i class="fas fa-project-diagram me-2 text-primary"></i>Lifecycle Flow Diagram
            </h2>
            
            <div class="flow-diagram p-5 rounded shadow">
                <div class="row text-center">
                    <!-- Mount -->
                    <div class="col-12 mb-4">
                        <div class="flow-step">
                            <h5 class="text-success mb-2">
                                <i class="fas fa-play-circle me-2"></i>1. mount()
                            </h5>
                            <p class="mb-0 small">Component initialization with parameters</p>
                        </div>
                        <div class="arrow">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>

                    <!-- Hydrate -->
                    <div class="col-12 mb-4">
                        <div class="flow-step">
                            <h5 class="text-secondary mb-2">
                                <i class="fas fa-download me-2"></i>2. hydrate()
                            </h5>
                            <p class="mb-0 small">Component receives state from frontend</p>
                        </div>
                        <div class="arrow">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>

                    <!-- Rendering -->
                    <div class="col-12 mb-4">
                        <div class="flow-step">
                            <h5 class="text-info mb-2">
                                <i class="fas fa-cog me-2"></i>3. rendering()
                            </h5>
                            <p class="mb-0 small">Before component renders</p>
                        </div>
                        <div class="arrow">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>

                    <!-- Render -->
                    <div class="col-12 mb-4">
                        <div class="flow-step bg-info text-white">
                            <h5 class="mb-2">
                                <i class="fas fa-paint-brush me-2"></i>4. render()
                            </h5>
                            <p class="mb-0 small">Component view is rendered</p>
                        </div>
                        <div class="arrow">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>

                    <!-- Rendered -->
                    <div class="col-12 mb-4">
                        <div class="flow-step">
                            <h5 class="text-info mb-2">
                                <i class="fas fa-check-circle me-2"></i>5. rendered()
                            </h5>
                            <p class="mb-0 small">After component renders</p>
                        </div>
                    </div>

                    <!-- User Interaction Loop -->
                    <div class="col-12 my-4">
                        <div class="bg-warning bg-opacity-20 p-4 rounded">
                            <h6 class="text-warning fw-bold mb-3">
                                <i class="fas fa-sync-alt me-2"></i>User Interaction Loop
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="flow-step">
                                        <h6 class="text-warning">updated()</h6>
                                        <small>Any property changes</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flow-step">
                                        <h6 class="text-warning">updatedProperty()</h6>
                                        <small>Specific property changes</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flow-step">
                                        <h6 class="text-secondary">dehydrate()</h6>
                                        <small>State sent to frontend</small>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center mt-3 mb-0 small">
                                <em>This loop repeats on every user interaction</em>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="section-divider">

    <!-- Lifecycle Methods Section -->
    <section id="methods" class="container my-5">
        <h2 class="text-center mb-5">
            <i class="fas fa-cogs me-2 text-primary"></i>Lifecycle Methods Detailed
        </h2>

        <div class="row g-4">
            <!-- Mount Method -->
            <div class="col-lg-6">
                <div class="card lifecycle-card mount-card h-100 border-0 shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-play-circle me-2"></i>mount()
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-success">When it runs:</h6>
                        <p>Once when the component is first instantiated</p>
                        
                        <h6 class="text-success">Use it for:</h6>
                        <ul>
                            <li>Setting initial property values</li>
                            <li>Accepting route parameters</li>
                            <li>Initial data loading</li>
                            <li>Setting default states</li>
                        </ul>

                        <h6 class="text-success">Code Example:</h6>
                        <pre class="code-example"><code class="language-php">public function mount($userId = null)
{
    $this->userId = $userId;
    $this->userName = $userId ? 
        User::find($userId)->name : 'Guest';
    $this->loadInitialData();
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Updated Methods -->
            <div class="col-lg-6">
                <div class="card lifecycle-card updated-card h-100 border-0 shadow">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>updated() / updatedProperty()
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-warning">When it runs:</h6>
                        <p>After any property is updated</p>
                        
                        <h6 class="text-warning">Use it for:</h6>
                        <ul>
                            <li>Real-time validation</li>
                            <li>Side effects on property changes</li>
                            <li>Dependent property updates</li>
                            <li>API calls based on input</li>
                        </ul>

                        <h6 class="text-warning">Code Example:</h6>
                        <pre class="code-example"><code class="language-php">public function updated($propertyName)
{
    $this->validateOnly($propertyName);
}

public function updatedEmail($value)
{
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $this->checkEmailAvailability($value);
    }
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Rendering Methods -->
            <div class="col-lg-6">
                <div class="card lifecycle-card render-card h-100 border-0 shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-paint-brush me-2"></i>rendering() / rendered()
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-info">When it runs:</h6>
                        <p>Before and after each component render</p>
                        
                        <h6 class="text-info">Use it for:</h6>
                        <ul>
                            <li>Data preparation before rendering</li>
                            <li>Computing derived properties</li>
                            <li>Logging and debugging</li>
                            <li>Performance monitoring</li>
                        </ul>

                        <h6 class="text-info">Code Example:</h6>
                        <pre class="code-example"><code class="language-php">public function rendering()
{
    $this->computedTotal = $this->items->sum('price');
    $this->lastRendered = now();
}

public function rendered()
{
    $this->renderCount++;
    Log::info('Component rendered', [
        'count' => $this->renderCount
    ]);
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Hydration Methods -->
            <div class="col-lg-6">
                <div class="card lifecycle-card hydrate-card h-100 border-0 shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exchange-alt me-2"></i>hydrate() / dehydrate()
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-secondary">When it runs:</h6>
                        <p>Before/after component state transfer</p>
                        
                        <h6 class="text-secondary">Use it for:</h6>
                        <ul>
                            <li>Complex state management</li>
                            <li>Custom serialization</li>
                            <li>Preparing data for frontend</li>
                            <li>Advanced debugging</li>
                        </ul>

                        <h6 class="text-secondary">Code Example:</h6>
                        <pre class="code-example"><code class="language-php">public function dehydrate()
{
    // Prepare data before sending to frontend
    $this->prepareForSerialization();
}

public function hydrate()
{
    // Restore data after receiving from frontend
    $this->restoreFromSerialization();
    $this->refreshCachedData();
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="section-divider">

    <!-- Code Examples Section -->
    <section id="examples" class="container my-5">
        <h2 class="text-center mb-5">
            <i class="fas fa-code me-2 text-primary"></i>Complete Code Examples
        </h2>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-header gradient-bg text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-file-code me-2"></i>Real-World Component Example
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6>UserProfile.php - Complete Lifecycle Implementation</h6>
                        <pre class="code-example"><code class="language-php">&lt;?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserProfile extends Component
{
    public $userId;
    public $name = '';
    public $email = '';
    public $bio = '';
    public $avatar;
    public $isEditing = false;
    
    // 1. MOUNT - Component Initialization
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadUserData();
        
        // Log component initialization
        logger('UserProfile component mounted', ['userId' => $userId]);
    }
    
    // 2. HYDRATE - State received from frontend
    public function hydrate()
    {
        // Refresh user data if needed
        $this->refreshUserPermissions();
    }
    
    // 3. UPDATED - Any property change
    public function updated($propertyName)
    {
        // Validate all updated properties
        $this->validateOnly($propertyName, [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'bio' => 'nullable|max:500'
        ]);
    }
    
    // 4. UPDATED SPECIFIC - Name property changed
    public function updatedName($value)
    {
        // Auto-generate slug from name
        $this->slug = Str::slug($value);
        
        // Real-time name availability check
        if (User::where('name', $value)->where('id', '!=', $this->userId)->exists()) {
            $this->addError('name', 'This name is already taken.');
        }
    }
    
    // 5. UPDATED SPECIFIC - Email property changed
    public function updatedEmail($value)
    {
        // Check email availability in real-time
        if (User::where('email', $value)->where('id', '!=', $this->userId)->exists()) {
            $this->addError('email', 'This email is already registered.');
        }
    }
    
    // 6. RENDERING - Before each render
    public function rendering()
    {
        // Prepare computed properties
        $this->computeProfileCompleteness();
        $this->lastActivity = $this->user->last_seen_at?->diffForHumans();
    }
    
    // 7. RENDERED - After each render
    public function rendered()
    {
        // Track render performance
        $this->incrementRenderCount();
    }
    
    // 8. DEHYDRATE - Before sending state to frontend
    public function dehydrate()
    {
        // Clean sensitive data before serialization
        unset($this->sensitiveData);
    }
    
    // Component Methods
    public function enableEditing()
    {
        $this->isEditing = true;
    }
    
    public function saveProfile()
    {
        $this->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'bio' => 'nullable|max:500'
        ]);
        
        User::find($this->userId)->update([
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio
        ]);
        
        $this->isEditing = false;
        session()->flash('message', 'Profile updated successfully!');
    }
    
    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->loadUserData(); // Reset to original data
    }
    
    // Helper Methods
    private function loadUserData()
    {
        $user = User::find($this->userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->bio = $user->bio;
    }
    
    private function computeProfileCompleteness()
    {
        $fields = [$this->name, $this->email, $this->bio, $this->avatar];
        $completed = collect($fields)->filter()->count();
        $this->profileCompleteness = ($completed / 4) * 100;
    }
    
    public function render()
    {
        return view('livewire.user-profile');
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="section-divider">

    <!-- Best Practices Section -->
    <section id="best-practices" class="container my-5">
        <h2 class="text-center mb-5">
            <i class="fas fa-star me-2 text-primary"></i>Best Practices & Tips
        </h2>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-thumbs-up me-2"></i>Do's
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Use <code>mount()</code> for initialization
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Validate in <code>updated()</code> methods
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Keep lifecycle methods lightweight
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Use property-specific updaters
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Log important lifecycle events
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-thumbs-down me-2"></i>Don'ts
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-times text-danger me-2"></i>
                                Don't override <code>render()</code> logic
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-times text-danger me-2"></i>
                                Avoid heavy operations in <code>rendering()</code>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-times text-danger me-2"></i>
                                Don't use lifecycle for complex logic
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-times text-danger me-2"></i>
                                Avoid infinite update loops
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-times text-danger me-2"></i>
                                Don't store large objects in properties
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-lightbulb me-2"></i>Pro Tips
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-star text-warning me-2"></i>
                                Use <code>wire:model.lazy</code> for performance
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-star text-warning me-2"></i>
                                Debounce API calls in updaters
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-star text-warning me-2"></i>
                                Cache computed properties
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-star text-warning me-2"></i>
                                Use <code>$this->skipRender()</code> when needed
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-star text-warning me-2"></i>
                                Test lifecycle methods thoroughly
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Execution Order Timeline -->
    <section class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-header gradient-bg text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2"></i>Execution Order Timeline
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="text-success">1. Component Instantiation</h6>
                                        <code>mount($param1, $param2)</code>
                                        <p class="mb-0 mt-2 small text-muted">Sets up initial state and properties</p>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="text-secondary">2. Initial Hydration</h6>
                                        <code>hydrate()</code>
                                        <p class="mb-0 mt-2 small text-muted">Component receives initial state</p>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="text-info">3. First Render Cycle</h6>
                                        <code>rendering() → render() → rendered()</code>
                                        <p class="mb-0 mt-2 small text-muted">Component is first displayed to user</p>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="text-warning">4. User Interaction Loop</h6>
                                        <code>dehydrate() → [frontend] → hydrate() → updated() → rendering() → render() → rendered()</code>
                                        <p class="mb-0 mt-2 small text-muted">Repeats on every user interaction</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="gradient-bg text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">
                <i class="fas fa-heart text-danger me-2"></i>
                Master Livewire 3 Component Lifecycle - Happy Coding!
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Prism.js for syntax highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    
    <!-- Smooth scrolling for navigation -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
