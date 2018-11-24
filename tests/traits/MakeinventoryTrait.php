<?php

use Faker\Factory as Faker;
use App\Models\inventory;
use App\Repositories\inventoryRepository;

trait MakeinventoryTrait
{
    /**
     * Create fake instance of inventory and save it in database
     *
     * @param array $inventoryFields
     * @return inventory
     */
    public function makeinventory($inventoryFields = [])
    {
        /** @var inventoryRepository $inventoryRepo */
        $inventoryRepo = App::make(inventoryRepository::class);
        $theme = $this->fakeinventoryData($inventoryFields);
        return $inventoryRepo->create($theme);
    }

    /**
     * Get fake instance of inventory
     *
     * @param array $inventoryFields
     * @return inventory
     */
    public function fakeinventory($inventoryFields = [])
    {
        return new inventory($this->fakeinventoryData($inventoryFields));
    }

    /**
     * Get fake data of inventory
     *
     * @param array $postFields
     * @return array
     */
    public function fakeinventoryData($inventoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'number' => $fake->randomDigitNotNull,
            'product' => $fake->randomDigitNotNull,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $inventoryFields);
    }
}
