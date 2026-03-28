<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Prskanje;

class PrskanjeTable extends Component
{
    // ...existing code...

    public function getTrgovackiNaziviProperty()
    {
        return Prskanje::where('user_id', auth()->id())
            ->distinct()
            ->orderBy('trgovacki_naziv_sredstva')
            ->pluck('trgovacki_naziv_sredstva')
            ->filter();
    }

    // ...existing code...
}
