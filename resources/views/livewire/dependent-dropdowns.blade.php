<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Dependent Dropdowns Demo
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <!-- Country Dropdown -->
                            <div class="col-md-4 mb-3">
                                <label for="country" class="form-label fw-bold">
                                    <i class="fas fa-globe me-1"></i>
                                    Country
                                </label>
                                <select wire:model.live="selectedCountry" id="country" class="form-select @error('selectedCountry') is-invalid @enderror">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedCountry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Dropdown -->
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label fw-bold">
                                    <i class="fas fa-map me-1"></i>
                                    State/Province
                                </label>
                                <select wire:model.live="selectedState" id="state" class="form-select @error('selectedState') is-invalid @enderror" @disabled(!$selectedCountry)>
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedState')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(!$selectedCountry)
                                    <div class="form-text text-muted">Please select a country first</div>
                                @endif
                            </div>

                            <!-- City Dropdown -->
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label fw-bold">
                                    <i class="fas fa-city me-1"></i>
                                    City
                                </label>
                                <select wire:model.live="selectedCity" id="city" class="form-select @error('selectedCity') is-invalid @enderror" @disabled(!$selectedState)>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedCity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(!$selectedState)
                                    <div class="form-text text-muted">Please select a state first</div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Select options in order: Country → State → City
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-check me-2"></i>
                                Submit Selection
                            </button>
                        </div>
                    </form>

                    <!-- Selection Preview -->
                    @if($selectedCountry || $selectedState || $selectedCity)
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="text-muted mb-2">Current Selection:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @if($selectedCountry)
                                    <span class="badge bg-primary">
                                        <i class="fas fa-globe me-1"></i>
                                        {{ $countries->find($selectedCountry)->name ?? '' }}
                                    </span>
                                @endif
                                @if($selectedState)
                                    <span class="badge bg-info">
                                        <i class="fas fa-map me-1"></i>
                                        {{ $states->find($selectedState)->name ?? '' }}
                                    </span>
                                @endif
                                @if($selectedCity)
                                    <span class="badge bg-success">
                                        <i class="fas fa-city me-1"></i>
                                        {{ $cities->find($selectedCity)->name ?? '' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>