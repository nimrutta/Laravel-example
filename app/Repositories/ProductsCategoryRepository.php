<?php

namespace App\Repositories;

use App\Models\ProductsCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductsCategoryRepository
 * @package App\Repositories
 * @version November 20, 2018, 2:15 pm UTC
 *
 * @method ProductsCategory findWithoutFail($id, $columns = ['*'])
 * @method ProductsCategory find($id, $columns = ['*'])
 * @method ProductsCategory first($columns = ['*'])
*/
class ProductsCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductsCategory::class;
    }
}
