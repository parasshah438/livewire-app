<div>
    {{-- Page Header --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="profile-card mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="text-white mb-2">
                                    <i class="fas fa-calendar-alt me-3"></i>Holiday API Integration
                                </h1>
                                <p class="text-white-75 mb-0">
                                    Fetch and display holidays from external API with real-time data
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <button wire:click="refreshData" class="btn btn-success-gradient" wire:loading.attr="disabled">
                                    <i class="fas fa-sync-alt me-2" wire:loading.class="fa-spin"></i>
                                    <span wire:loading.remove>Refresh Data</span>
                                    <span wire:loading>Refreshing...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="row justify-content-center mb-4">
            <div class="col-12">
                <div class="profile-card">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="country" class="form-label">
                                    <i class="fas fa-globe me-2"></i>Select Country
                                </label>
                                <select wire:change="changeCountry($event.target.value)" 
                                        id="country" 
                                        class="form-select"
                                        onchange="updateLoadingText(this.value, 'country')">
                                    @foreach($countries as $code => $name)
                                        <option value="{{ $code }}" {{ $selectedCountry == $code ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="year" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Select Year
                                </label>
                                <select wire:change="changeYear($event.target.value)" 
                                        id="year" 
                                        class="form-select"
                                        onchange="updateLoadingText(this.value, 'year')">
                                    @for($year = 2020; $year <= now()->year + 2; $year++)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }} @if($year > now()->year) (Future - may not have data) @endif</option>
                                    @endfor
                                </select>
                                <small class="text-white-75 mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    For best results, try years 2020-2025. Future years may not have data available yet.
                                </small>
                            </div>
                        </div>
                        
                        {{-- Summary Info --}}
                        @if(!$loading && !$error && $totalHolidays > 0)
                        <div class="alert alert-info-custom mt-3 d-flex align-items-center">
                            <i class="fas fa-info-circle alert-icon me-3 fs-4"></i>
                            <div>
                                <strong>{{ $totalHolidays }} holidays</strong> found for 
                                <strong>{{ $countries[$selectedCountry] }}</strong> in <strong>{{ $selectedYear }}</strong>
                                <br>
                                <small>Displaying {{ $paginatedHolidays->count() }} holidays on this page ({{ $paginatedHolidays->firstItem() }} - {{ $paginatedHolidays->lastItem() }})</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session()->has('success'))
        <div class="row justify-content-center mb-4">
            <div class="col-12">
                <div class="alert alert-success-custom d-flex align-items-center">
                    <i class="fas fa-check-circle alert-icon me-3 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Success!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Error State --}}
        @if($error)
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Error</h6>
                        <p class="mb-2">{{ $error }}</p>
                        <button wire:click="fetchHolidays" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-retry me-1"></i>Try Again
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Holidays Table --}}
        @if(!$error)
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="profile-card">
                    <div class="card-body p-0">
                        {{-- Loading overlay for table updates --}}
                        <div class="position-absolute w-100 h-100 justify-content-center align-items-center d-none" 
                             style="background: rgba(0,0,0,0.8); z-index: 1000; min-height: 400px; border-radius: 20px;"
                             wire:loading.class.remove="d-none"
                             wire:loading.class="d-flex"
                             wire:target="changeCountry,changeYear,fetchHolidays,refreshData"
                             id="loadingOverlay">
                            <div class="text-center">
                                <div class="spinner-border text-light me-3" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h5 class="text-white mt-3">Updating holidays data...</h5>
                                <p class="text-white-75" id="loadingText">Fetching data for {{ $countries[$selectedCountry] }} {{ $selectedYear }}</p>
                            </div>
                        </div>

                        @if($totalHolidays > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">
                                            <i class="fas fa-hashtag me-2"></i>#
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            <i class="fas fa-calendar-day me-2"></i>Holiday Name
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            <i class="fas fa-calendar me-2"></i>Date
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            <i class="fas fa-clock me-2"></i>Day of Week
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            <i class="fas fa-info me-2"></i>Type
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paginatedHolidays as $index => $holiday)
                                    <tr style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                                        <td class="px-4 py-3 text-white fw-bold">
                                            {{ $paginatedHolidays->firstItem() + $index }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-star text-warning me-2"></i>
                                                <div>
                                                    <h6 class="text-white mb-0 fw-bold">{{ $holiday['name'] ?? 'N/A' }}</h6>
                                                    @if(isset($holiday['description']) && $holiday['description'])
                                                        <small class="text-white-75">{{ $holiday['description'] }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-primary fs-6 py-2 px-3">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                {{ \Carbon\Carbon::parse($holiday['date'])->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-white fw-bold">
                                                {{ \Carbon\Carbon::parse($holiday['date'])->format('l') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if(isset($holiday['type']))
                                                @php
                                                    $typeColor = match(strtolower($holiday['type'])) {
                                                        'public' => 'success',
                                                        'national' => 'primary',
                                                        'regional' => 'info',
                                                        'religious' => 'warning',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $typeColor }} py-2 px-3">
                                                    <i class="fas fa-tag me-1"></i>{{ ucfirst($holiday['type']) }}
                                                </span>
                                            @else
                                                <span class="text-white-75">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Pagination --}}
                        @if($paginatedHolidays->hasPages())
                        <div class="p-4 border-top" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-white-75">
                                    Showing {{ $paginatedHolidays->firstItem() }} to {{ $paginatedHolidays->lastItem() }} of {{ $paginatedHolidays->total() }} results
                                </div>
                                <div>
                                    {{ $paginatedHolidays->links() }}
                                </div>
                            </div>
                        </div>
                        @endif

                        @else
                        {{-- Empty State --}}
                        <div class="p-5 text-center" @if(!$loading) wire:loading.remove wire:target="updatedSelectedCountry,updatedSelectedYear,fetchHolidays" @endif>
                            <i class="fas fa-calendar-times text-white-75 mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-white mb-3">No Holidays Found</h4>
                            <p class="text-white-75 mb-4">
                                No holiday data available for {{ $countries[$selectedCountry] }} in {{ $selectedYear }}.
                                <br>Try selecting a different country or year.
                            </p>
                            <button wire:click="fetchHolidays" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Search Again
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Custom Styles for Pagination --}}
    <style>
        .pagination {
            --bs-pagination-bg: rgba(255, 255, 255, 0.1);
            --bs-pagination-border-color: rgba(255, 255, 255, 0.2);
            --bs-pagination-color: #fff;
            --bs-pagination-hover-bg: rgba(255, 255, 255, 0.2);
            --bs-pagination-hover-color: #fff;
            --bs-pagination-focus-bg: rgba(255, 255, 255, 0.15);
            --bs-pagination-focus-color: #fff;
            --bs-pagination-active-bg: #0d6efd;
            --bs-pagination-active-border-color: #0d6efd;
            --bs-pagination-disabled-color: rgba(255, 255, 255, 0.5);
            --bs-pagination-disabled-bg: rgba(255, 255, 255, 0.05);
        }
        
        .pagination .page-link {
            backdrop-filter: blur(10px);
            border-radius: 8px !important;
            margin: 0 2px;
        }
        
        .table {
            --bs-table-bg: transparent;
        }
        
        .table thead th {
            background: rgba(0, 0, 0, 0.3) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            font-weight: 600;
        }
        
        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.1) !important;
        }
        
        .table tbody td {
            border-color: rgba(255, 255, 255, 0.1) !important;
            vertical-align: middle;
        }
    </style>

    <script>
        let currentCountry = '{{ $countries[$selectedCountry] }}';
        let currentYear = '{{ $selectedYear }}';
        
        const countries = {
            @foreach($countries as $code => $name)
                '{{ $code }}': '{{ $name }}',
            @endforeach
        };

        function updateLoadingText(value, type) {
            if (type === 'country') {
                currentCountry = countries[value];
            } else if (type === 'year') {
                currentYear = value;
            }
            
            const loadingText = document.getElementById('loadingText');
            if (loadingText) {
                loadingText.textContent = `Fetching data for ${currentCountry} ${currentYear}`;
            }
        }
    </script>
</div>