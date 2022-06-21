<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\Denomination;

class Pos extends Component
{
    public $total=10, $itemsQuantity=1, $cart=[], $denominations=[], $efectivo, $change;

    public function render()
    {
        $this->denominations = Denomination::all();
        return view('livewire.pos.pos')
                ->extends('layouts.theme.app')
                ->section('content');
    }


}
