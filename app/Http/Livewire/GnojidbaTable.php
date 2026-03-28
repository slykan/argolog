<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Gnojidba;

class GnojidbaTable extends Component
{
    // ...existing code...

    public function getTipoviGnojivaProperty()
    {
        return Gnojidba::where('user_id', auth()->id())
            ->distinct()
            ->orderBy('tip_gnojiva')
            ->pluck('tip_gnojiva')
            ->filter();
    }

    // ...existing code...
}
