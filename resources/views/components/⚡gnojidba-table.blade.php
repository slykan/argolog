<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Gnojidba;
use App\Models\Kultura;

new class extends Component
{
    public string $search = '';
    public array $filters = [
        'arkod'     => '',
        'kultura'   => '',
        'datum'     => '',
        'gnojivo'   => '',
    ];

    public bool $showForm = false;
    public array $form = [
        'kultura_id'     => '',
        'datum'          => '',
        'tip_gnojiva'    => '',
        'kolicina_kg_ha' => '',
    ];

    public ?int $editingId = null;
    public array $editForm = [];

    public array $visibleColumns = ['arkod','povrsina','kultura','datum','gnojivo','kolicina'];

    #[Computed]
    public function kulture()
    {
        return Kultura::where('user_id', auth()->id())
            ->with('parcela')
            ->join('parcele', 'parcele.id', '=', 'kulture.parcela_id')
            ->orderBy('parcele.arkod_broj')
            ->orderBy('kulture.naziv')
            ->select('kulture.*')
            ->get();
    }

    #[Computed]
    public function gnojidbe()
    {
        $q = Gnojidba::where('gnojidbe.user_id', auth()->id())
            ->join('kulture', 'kulture.id', '=', 'gnojidbe.kultura_id')
            ->join('parcele', 'parcele.id', '=', 'kulture.parcela_id')
            ->select('gnojidbe.*', 'kulture.naziv as kultura_naziv', 'kulture.posadjena_povrsina_ha',
                     'parcele.arkod_broj', 'parcele.povrsina_ha')
            ->orderByDesc('gnojidbe.datum')
            ->orderByDesc('gnojidbe.id');

        if ($this->search) {
            $s = '%' . $this->search . '%';
            $q->where(function($q) use ($s) {
                $q->where('parcele.arkod_broj', 'like', $s)
                  ->orWhere('kulture.naziv', 'like', $s)
                  ->orWhere('gnojidbe.tip_gnojiva', 'like', $s);
            });
        }
        if ($this->filters['arkod'])   $q->where('parcele.arkod_broj', 'like', '%'.$this->filters['arkod'].'%');
        if ($this->filters['kultura']) $q->where('kulture.naziv', 'like', '%'.$this->filters['kultura'].'%');
        if ($this->filters['datum'])   $q->whereDate('gnojidbe.datum', $this->filters['datum']);
        if ($this->filters['gnojivo']) $q->where('gnojidbe.tip_gnojiva', 'like', '%'.$this->filters['gnojivo'].'%');

        return $q->get();
    }

    public function addRow(): void
    {
        $this->showForm = true;
        $this->form = ['kultura_id' => '', 'datum' => now()->format('Y-m-d'), 'tip_gnojiva' => '', 'kolicina_kg_ha' => ''];
    }

    public function saveNew(): void
    {
        $this->validate([
            'form.kultura_id'     => 'required|exists:kulture,id',
            'form.datum'          => 'required|date',
            'form.tip_gnojiva'    => 'required|string|max:255',
            'form.kolicina_kg_ha' => 'required|numeric|min:0',
        ]);

        Gnojidba::create([
            'user_id'        => auth()->id(),
            'kultura_id'     => $this->form['kultura_id'],
            'datum'          => $this->form['datum'],
            'tip_gnojiva'    => $this->form['tip_gnojiva'],
            'kolicina_kg_ha' => $this->form['kolicina_kg_ha'],
        ]);

        $this->showForm = false;
        session()->flash('success', 'Gnojidba dodana.');
    }

    public function startEdit(int $id): void
    {
        $g = Gnojidba::findOrFail($id);
        $this->editingId = $id;
        $this->editForm = [
            'kultura_id'     => $g->kultura_id,
            'datum'          => $g->datum->format('Y-m-d'),
            'tip_gnojiva'    => $g->tip_gnojiva,
            'kolicina_kg_ha' => $g->kolicina_kg_ha,
        ];
    }

    public function saveEdit(): void
    {
        $this->validate([
            'editForm.kultura_id'     => 'required|exists:kulture,id',
            'editForm.datum'          => 'required|date',
            'editForm.tip_gnojiva'    => 'required|string|max:255',
            'editForm.kolicina_kg_ha' => 'required|numeric|min:0',
        ]);

        $g = Gnojidba::where('id', $this->editingId)->where('user_id', auth()->id())->firstOrFail();
        $g->update($this->editForm);
        $this->editingId = null;
    }

    public function cancelEdit(): void { $this->editingId = null; }

    public function deleteRow(int $id): void
    {
        Gnojidba::where('id', $id)->where('user_id', auth()->id())->delete();
    }

    public function toggleColumn(string $col): void
    {
        if (in_array($col, $this->visibleColumns)) {
            $this->visibleColumns = array_values(array_filter($this->visibleColumns, fn($c) => $c !== $col));
        } else {
            $this->visibleColumns[] = $col;
        }
    }

    public function render() { return view('livewire.gnojidba-table'); }
};
?>
