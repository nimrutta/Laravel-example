<?php

namespace App\Repositories;

use App\Models\inventory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class inventoryRepository
 * @package App\Repositories
 * @version November 20, 2018, 1:38 pm UTC
 *
 * @method inventory findWithoutFail($id, $columns = ['*'])
 * @method inventory find($id, $columns = ['*'])
 * @method inventory first($columns = ['*'])
*/
class inventoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'number',
        'product'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return inventory::class;
    }
}
