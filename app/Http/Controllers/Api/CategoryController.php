<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleChangeRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Repositorys\CategoryRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use ResponseTrait;

    /**
     * @var CategoryRepositry
     */
    protected CategoryRepository $categoryRepositry;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $categoryRepositry)
    {
        $this->categoryRepositry =  $categoryRepositry;
    }

    /**
     * list function
     *
     * @return void
     */
    public function list()
    {
        // $data = array();
        // $data[]
        $categories = $this->categoryRepositry->allCategorys2();
        return $this->returnData('Categorys', CategoryResource::collection($categories), __('Succesfully'));
    }

    /**
     * paginate
     *
     * @return void
     */
    public function paginate()
    {
        $categories = $this->categoryRepositry->categoryPagination();
        return $this->returnData('Categorys', CategoryResource::collection($categories), __('Succesfully'));
    }

    /**
     * store function
     *
     * @param CategoryRequest $request
     * @return void
     */
    public function store(CategoryRequest $request)
    {

        $category = $this->categoryRepositry->saveCategory($request);

        if ($category) {
            return $this->returnData('Category', CategoryResource::make($category), __('Category created succesfully'));
        }

        return $this->returnError(__('Sorry! Failed to create Category!'));
    }

    /**
     * profile function
     *
     * @param [type] $id
     * @return void
     */
    public function profile(Request $request, $id)
    {
        $category = $this->categoryRepositry->getCategoryByID($id);
        if( !empty( $request->supplier_id ) ){
            if ($category) {
                return $this->returnData('products', ProductResource::collection($category->products->where( 'user_id', $request->supplier_id )), __('Get Category succesfully'));
            }
        }
        if ($category) {
            return $this->returnData('Category', CategoryResource::make($category), __('Get Category succesfully'));
        }

        return $this->returnError(__('Sorry! Failed to get Category!'));
    }

    /**
     * delete function
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        $this->categoryRepositry->deleteCategory($id);

        return $this->returnSuccessMessage(__('Delete Category succesfully!'));
    }

    /**
     * changeRole function
     *
     * @param [type] $id
     * @param RoleChangeRequest $request
     * @return void
     */
    public function changeRole($id, RoleChangeRequest $request)
    {
        $category = $this->categoryRepositry->asignRoleToCategory($id, $request->roles);

        if ($category) {
            return $this->returnSuccessMessage(__('Roles changed successfully!'));
        }

        return $this->returnError(__('Sorry! Category not found'));
    }
}
