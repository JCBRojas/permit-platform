<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Diet;

class DietsManager extends Component
{
    /* ===================== CONFIRM ===================== */
    public function confirmRecord($id)
    {
        $diet = Diet::find($id);

        if (! $diet) {
            return;
        }

        $diet->confirmed = ! (bool) $diet->confirmed;
        $diet->save();
    }

    /* ===================== RENDER ===================== */
    public function render()
    {
        return view('livewire.diet-manager', [
            'diets' => Diet::all(),
            // 'timeFood' => $this->timeFood,
            // 'consistency' => $this->consistency,
            // 'specifications' => $this->specifications,
        ]);
    }
}