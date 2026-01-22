<?php

namespace App\View\Components\Category;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormCategory extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $nama_category, $description;
    public function __construct($id = null)
    {
    if($id) {
        $category = Category::find($id);
        $this->id = $category->id;
        $this->nama_category = $category->nama_category;
        $this->description = $category->description;
    }
}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category.form-category');
    }
}
