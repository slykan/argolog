<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Prskanje;
use App\Models\Kultura;

new class extends Component
{
    public string $search = '';
    public array $filters = ['datum' => '', 'arkod' => '', 'kultura' => '', 'sredstvo' => ''];

    public bool $showForm = false;
    public array $form = [
        'kultura_id' => '', 'datum_tretiranja' => '',
        'tretirana_povrsina_ha' => '', 'trgovacki_naziv_sredstva' => '',
        'kolicina_sredstva_l_ha' => '', 'vrijeme_od' => '', 'vrijeme_do' => '',
        'kolicina_vode_l_ha' => '',
    ];

    public ?int $editingId = null;
    public array $editForm = [];
    public array $visibleColumns = ['datum','arkod','kultura','vel_povrsina','tret_povrsina','sredstvo','kolicina','vrijeme','voda'];

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
    public function prskanja()
    {
        $q = Prskanje::where('prskanja.user_id', auth()->id())
            ->join('kulture', 'kulture.id', '=', 'prskanja.kultura_id')
            ->join('parcele', 'parcele.id', '=', 'kulture.parcela_id')
            ->select('prskanja.*', 'kulture.naziv as kultura_naziv',
                     'kulture.posadjena_povrsina_ha', 'parcele.arkod_broj')
            ->orderByDesc('prskanja.datum_tretiranja')
            ->orderByDesc('prskanja.id');

        if ($this->search) {
            $s = '%' . $this->search . '%';
            $q->where(fn($q) => $q
                ->where('parcele.arkod_broj', 'like', $s)
                ->orWhere('kulture.naziv', 'like', $s)
                ->orWhere('prskanja.trgovacki_naziv_sredstva', 'like', $s));
        }
        if ($this->filters['datum'])   $q->whereDate('prskanja.datum_tretiranja', $this->filters['datum']);
        if ($this->filters['arkod'])   $q->where('parcele.arkod_broj', 'like', '%'.$this->filters['arkod'].'%');
        if ($this->filters['kultura']) $q->where('kulture.naziv', 'like', '%'.$this->filters['kultura'].'%');
        if ($this->filters['sredstvo']) $q->where('prskanja.trgovacki_naziv_sredstva', 'like', '%'.$this->filters['sredstvo'].'%');

        return $q->get();
    }

    public function addRow(): void
    {
        $this->showForm = true;
        $this->form = array_merge($this->form, ['datum_tretiranja' => now()->format('Y-m-d'), 'kultura_id' => '']);
    }

    public function saveNew(): void
    {
        $this->validate([
            'form.kultura_id'              => 'required|exists:kulture,id',
            'form.datum_tretiranja'        => 'required|date',
            'form.tretirana_povrsina_ha'   => 'required|numeric|min:0',
            'form.trgovacki_naziv_sredstva'=> 'required|string|max:255',
            'form.kolicina_sredstva_l_ha'  => 'required|numeric|min:0',
        ]);

        Prskanje::create(array_merge($this->form, ['user_id' => auth()->id()]));
        $this->showForm = false;
        session()->flash('success', 'Tretman dodan.');
    }

    public function startEdit(int $id): void
    {
        $p = Prskanje::findOrFail($id);
        $this->editingId = $id;
        $this->editForm = [
            'kultura_id'               => $p->kultura_id,
            'datum_tretiranja'         => $p->datum_tretiranja->format('Y-m-d'),
            'tretirana_povrsina_ha'    => $p->tretirana_povrsina_ha,
            'trgovacki_naziv_sredstva' => $p->trgovacki_naziv_sredstva,
            'kolicina_sredstva_l_ha'   => $p->kolicina_sredstva_l_ha,
            'vrijeme_od'               => $p->vrijeme_od,
            'vrijeme_do'               => $p->vrijeme_do,
            'kolicina_vode_l_ha'       => $p->kolicina_vode_l_ha,
        ];
    }

    public function saveEdit(): void
    {
        $this->validate([
            'editForm.kultura_id'              => 'required|exists:kulture,id',
            'editForm.datum_tretiranja'        => 'required|date',
            'editForm.tretirana_povrsina_ha'   => 'required|numeric|min:0',
            'editForm.trgovacki_naziv_sredstva'=> 'required|string|max:255',
            'editForm.kolicina_sredstva_l_ha'  => 'required|numeric|min:0',
        ]);

        Prskanje::where('id', $this->editingId)->where('user_id', auth()->id())->firstOrFail()->update($this->editForm);
        $this->editingId = null;
    }

    public function cancelEdit(): void { $this->editingId = null; }

    public function deleteRow(int $id): void
    {
        Prskanje::where('id', $id)->where('user_id', auth()->id())->delete();
    }

    public function toggleColumn(string $col): void
    {
        if (in_array($col, $this->visibleColumns)) {
            $this->visibleColumns = array_values(array_filter($this->visibleColumns, fn($c) => $c !== $col));
        } else {
            $this->visibleColumns[] = $col;
        }
    }

    public function render() { return view('livewire.prskanje-table'); }
};
?>
