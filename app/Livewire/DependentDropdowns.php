<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Livewire\Component;

class DependentDropdowns extends Component
{
    public $countries = [];
    public $states = [];
    public $cities = [];
    
    public $selectedCountry = null;
    public $selectedState = null;
    public $selectedCity = null;

    public function mount()
    {
        $this->countries = Country::all();
    }

    public function updatedSelectedCountry($countryId)
    {
        $this->selectedState = null;
        $this->selectedCity = null;
        $this->cities = [];
        
        if ($countryId) {
            $this->states = State::where('country_id', $countryId)->get();
        } else {
            $this->states = [];
        }
    }

    public function updatedSelectedState($stateId)
    {
        $this->selectedCity = null;
        
        if ($stateId) {
            $this->cities = City::where('state_id', $stateId)->get();
        } else {
            $this->cities = [];
        }
    }

    public function submit()
    {
        $this->validate([
            'selectedCountry' => 'required',
            'selectedState' => 'required',
            'selectedCity' => 'required',
        ]);

        $country = Country::find($this->selectedCountry);
        $state = State::find($this->selectedState);
        $city = City::find($this->selectedCity);

        session()->flash('message', "Selected: {$city->name}, {$state->name}, {$country->name}");
    }

    public function render()
    {
        return view('livewire.dependent-dropdowns');
    }
}