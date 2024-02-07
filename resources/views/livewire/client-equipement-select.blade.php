<div>
    <div class="service-fields mb-3">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="client-select">Client:</label>
                    <select class="select2 form-select form-control" id="client-select" wire:model="selectedClient" onchange="livewire.emit('loadEquipments', this.value)">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if (!is_null($selectedClient))
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="equipement">{{ __('Equipement') }}</label>
                        <select wire:model="selectedEquipement" class="select2 form-control" name="equipement_name">
                            <option value="" selected>--Sélectionner un Equipement--</option>
                            @foreach($equipements as $equipement)
                                <option value="{{ $equipement->id_equipement }}">{{ $equipement->modele.'--'.$equipement->numserie }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            @if (!is_null($selectedEquipement))
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="sousequipement">{{ __('Sousequipement') }}</label>
                        <select wire:model="selectedSousequipement" class="select2 form-control" name="souseq_name" >
                            <option value="" selected>--Sélectionner un Sousequipement--</option>
                            @foreach($sousequipements as $sousequipement)
                                <option value="{{ $sousequipement->id_sousequipement }}">{{ $sousequipement->designation }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $('.select2').select2();
        });

        document.addEventListener('livewire:load', function () {
            Livewire.hook('element.updated', (el, component) => {
                $('.select2').select2(); // Reinitialize Select2 after Livewire update
            });
        });
    </script>
@endpush
