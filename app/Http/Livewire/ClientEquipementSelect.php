<?php

namespace App\Http\Livewire;
use Livewire\Component;

use App\Models\Client;
use App\Models\Equipement;
use App\Models\Sousequipement;


class ClientEquipementSelect extends Component
{   
    public $selectedClient;
    public $selectedEquipement;
    public $selectedSousequipement;


    public function mount($selectedSousequipement = null)
    {
        $this->clients = Client::orderBy('name','asc')->get();
        $this->equipements= Equipement::orderBy('modele')->get();
        $this->sousequipements = collect();
        $this->selectedSousequipement = $selectedSousequipement;

        if (!is_null($selectedSousequipement)) {
            $sousequipement = Sousequipement::with('equipement.client')->find($selectedSousequipement);
            if ($sousequipement) {
                $this->sousequipements = Sousequipement::where('equipement_id_equipement', $sousequipement->equipement_id)->get();
                $this->equipements = Equipement::where('client_id', $sousequipement->equipement->equipement_id)->get();
                $this->selectedClient = $sousequipement->equipement->client_id;
                $this->selectedEquipement= $sousequipement->equipement_id;
            }
        }
    }
    public function render()
    {
        $clients = Client::all();
        $equipments = Equipement::where('client_id', $this->selectedClient)->get();

        return view('livewire.client-equipement-select', compact('clients', 'equipments'));
    }

    public function loadEquipments()
    {
        $this->selectedEquipment = null;
        $this->render();
    }

    public function updatedSelectedClient($client)
    {
        $this->equipements = Equipement::where('client_id', $client)->get();
        $this->selectedEquipement = NULL;
    }

    public function updatedSelectedEquipement($equipement)
    {
        if (!is_null($equipement)) {
            $this->sousequipements = Sousequipement::where('equipement_id', $equipement)->get();
            $this->selectedSousequipement = NULL;
        }
    }
}
