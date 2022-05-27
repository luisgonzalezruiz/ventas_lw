<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;

use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    use AuthorizesRequests;

    //protected $paginationTheme = 'bootstrap';
    //protected $listeners       = [
    //    'deleteCategory' => 'destroy'
    //];

    public $name, $selected_id; //?Category $object;
    public $search;
    public $image;
    public $pageTitle;
    public $componentName;


    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Categorías';
        $this->pagination    = 3;
        $this->search        = '';
       // $this->object        = null;
    }

    // limpiamos el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // de esta forma especificamos que queremos usar una paginacion personalizada
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search)) {
            $categories = Category::where('name', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc')->paginate($this->pagination);
        } else {
            $categories = Category::orderBy('id', 'desc')->paginate($this->pagination);
        }
        // lo que decimos aqui es: va a renderizar en la seccion content que esta en la plantilla
        // loyouts/theme y el archico app.blade.php
        return view('livewire.category.categories', compact('categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

}
