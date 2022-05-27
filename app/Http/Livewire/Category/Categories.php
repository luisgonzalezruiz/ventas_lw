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
    public string $search;
    public $image;
    public string $pageTitle;
    public string $componentName;

    private $pagination = 5;

    /*
    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Categorías';
        $this->pagination    = 5;
        $this->search        = '';
        $this->object        = null;
    }
    */

    public function render()
    {
        $categories = Category::all();
        // lo que decimos aqui es: va a renderizar en la seccion content que esta en la plantilla
        // loyouts/theme y el archico app.blade.php
        return view('livewire.category.categories', compact('categories'))
        ->extends('layouts.theme.app')
        ->section('content');
    }

}
