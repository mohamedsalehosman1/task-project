<?php

namespace Modules\Categories\Repositories;

use File;
use Modules\Contracts\CrudRepository;
use Modules\Categories\Entities\Category;
use Modules\Categories\Http\Filters\CategoryFilter;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryRepository implements CrudRepository
{
   
    private $filter;

    public function __construct(CategoryFilter $filter)
    {
        $this->filter = $filter;
    }

   
    public function all()
    {
        return Category::filter($this->filter)->paginate(request('perPage'));
    }

    public function create(array $data)
    {
        $category = Category::create($data);
        return $category;
    }

   
    public function find($model)
    {
        if ($model instanceof Category) {
            return $model;
        }
        return Category::findOrFail($model);
    }

    public function update($model, array $data)
    {
        $category = $this->find($model);
        $category->update($data);
        return $category;
    }

   
    public function delete($model)
    {
        $this->find($model)->delete();
    }

   
    public function order()
    {
        return Category::orderBy('rank', 'asc')->filter($this->filter)->get();
    }
   

}
