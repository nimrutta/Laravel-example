<?php

namespace App\Repositories;

use App\Models\product;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class productRepository
 * @package App\Repositories
 * @version November 20, 2018, 2:07 pm UTC
 *
 * @method product findWithoutFail($id, $columns = ['*'])
 * @method product find($id, $columns = ['*'])
 * @method product first($columns = ['*'])
*/
class productRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'product_category_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return product::class;
    }
}
