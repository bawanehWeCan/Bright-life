<?php

namespace App\Repositorys;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class CategoryRepository
{

    /**
     * @var Category
     */
    protected $category;

    /**
     * __construct function
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * allCategorys function
     *
     * @return Collection
     */
    public function allCategorys()
    {
        $categorys = $this->category->all();
        return $categorys;
    }

    /**
     * categoryPagination
     *
     * @param  mixed $length
     * @return void
     */
    public function categoryPagination($length = 10)
    {
        $categorys = $this->category->paginate($length);
        return $categorys;
    }

    public function allCategorys2()
    {
        $categorys = $this->category->get();
        return $categorys;
    }

    /**
     * saveCategory function
     *
     * @param Array $data
     * @return void
     */
    public function saveCategory($data)
    {

        $category = new $this->category;
        $category->name = ['en'=>$data['name_en'],'ar'=>$data['name_ar']];
        $category->image = $data['image'];
        $category->save();

        return $category->fresh();
    }

    /**
     * getCategoryByID function
     *
     * @return Collection
     */
    public function getCategoryByID($id)
    {
        $category = $this->category->where('id', $id)->firstOrFail();
        return $category;
    }

    /**
     * deleteCategory function
     *
     * @return bool
     */
    public function deleteCategory($id)
    {
        Category::destroy($id);
    }

}
