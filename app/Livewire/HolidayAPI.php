<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class HolidayAPI extends Component
{
    use WithPagination;

    public $selectedCountry = 'US';
    public $selectedYear = 2026;
    public $holidays = [];
    public $loading = false;
    public $error = null;
    public $totalHolidays = 0;
    
    // Available countries for dropdown
    public $countries = [
        'US' => 'United States',
        'GB' => 'United Kingdom',
        'CA' => 'Canada',
        'AU' => 'Australia',
        'DE' => 'Germany',
        'FR' => 'France',
        'IT' => 'Italy',
        'ES' => 'Spain',
        'JP' => 'Japan',
        'IN' => 'India',
        'BR' => 'Brazil',
        'MX' => 'Mexico',
        'RU' => 'Russia',
        'CN' => 'China',
        'ZA' => 'South Africa'
    ];
    
    protected $paginationTheme = 'bootstrap';
    
    public function mount()
    {
        //$this->selectedYear = 2026;
        $this->fetchHolidays();
    }
    
    public function updatedSelectedCountry()
    {
        $this->resetPage();
        $this->fetchHolidays();
    }
    
    public function updatedSelectedYear()
    {
        $this->resetPage();
        $this->fetchHolidays();
    }
    
    public function changeCountry($country)
    {
        $this->selectedCountry = $country;
        $this->dispatch('$refresh'); // Force UI update to show new country in loader
        $this->resetPage();
        $this->fetchHolidays();
    }
    
    public function changeYear($year)
    {
        $this->selectedYear = $year;
        $this->dispatch('$refresh'); // Force UI update to show new year in loader
        $this->resetPage();
        $this->fetchHolidays();
    }
    
    public function fetchHolidays()
    {
        $this->loading = true;
        $this->error = null;
        
        try {
            $response = Http::timeout(30)
                ->withOptions([
                    'verify' => false, // Disable SSL verification for localhost development
                    'curl' => [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_SSL_VERIFYHOST => false,
                    ]
                ])
                ->get('https://api.11holidays.com/v1/holidays', [
                    'country' => $this->selectedCountry,
                    'year' => $this->selectedYear
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Debug: Log the response structure
                \Log::info('Holiday API Response:', $data);
                
                // Handle different possible response structures
                if (isset($data['holidays']) && is_array($data['holidays'])) {
                    $this->holidays = collect($data['holidays']);
                } elseif (isset($data) && is_array($data)) {
                    // If the response is directly an array of holidays
                    $this->holidays = collect($data);
                } else {
                    $this->holidays = collect([]);
                }
                
                $this->totalHolidays = $this->holidays->count();
                
                if ($this->totalHolidays === 0) {
                    $this->error = "No holidays found for {$this->countries[$this->selectedCountry]} in {$this->selectedYear}. Try a different year (like 2024 or 2025).";
                }
            } else {
                $this->error = 'API returned status: ' . $response->status() . '. Response: ' . $response->body();
                $this->holidays = collect([]);
            }
        } catch (\Exception $e) {
            $this->error = 'Connection error: ' . $e->getMessage();
            $this->holidays = collect([]);
        }
        
        $this->loading = false;
    }
    
    public function refreshData()
    {
        $this->fetchHolidays();
        session()->flash('success', 'Holiday data refreshed successfully!');
    }
    
    public function getPaginatedHolidays()
    {
        $perPage = 10;
        $currentPage = $this->getPage();
        
        $items = $this->holidays->forPage($currentPage, $perPage);
        
        return new LengthAwarePaginator(
            $items,
            $this->totalHolidays,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
    }
    
    public function render()
    {
        $paginatedHolidays = $this->getPaginatedHolidays();
        
        return view('livewire.holiday-api', [
            'paginatedHolidays' => $paginatedHolidays
        ])
        ->layout('layouts.app-livewire')
        ->title('Holiday API - External API Integration');
    }
}