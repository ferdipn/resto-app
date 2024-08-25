<?php

namespace App\Livewire\Admin\Restaurant;

use App\Livewire\Forms\PostForm;
use Livewire\Component;
use App\Models\Restaurant;
use App\Models\RestaurantOperationHour;
use DB;
use Exception;

class Form extends Component
{
    public $operationHours = [
        'Monday' => [
            'is_open' => false, 
            'open' => '',
            'close' => '',
            'day' => '1'
        ],
        'Tuesday' => [
            'is_open' => false,
            'open' => '',
            'close' => '',
            'day' => '2'
        ],
        'Wednesday' => [
            'is_open' => false,
            'open' => '',
            'close' => '',
            'day' => '3'
        ],
        'Thursday' => [
            'is_open' => false,
            'open' => '',
            'close' => '',
            'day' => '4'
        ],
        'Friday' => [
            'is_open' => false,
            'open' => '',
            'close' => '',
            'day' => '5'
        ],
        'Saturday' => [
            'is_open' => false,
            'open' => '',
            'close' => '',
            'day' => '6'
        ],
        'Sunday' => [
            'is_open' => false,
            'open' => '',
            'close' => '',
            'day' => '7'
        ],
    ];

    public $name = '';
    public $address = '';

    public function toogleOpenOperational($day)
    {
        $this->operationHours[$day]['is_open'] = !$this->operationHours[$day]['is_open'];
    }

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function storeData()
    {
        try {
            $name = $this->name;
            $address = $this->address;
            $operationHours = $this->operationHours;
            return DB::transaction(function () use ($name, $address, $operationHours) {

                $restaurant = new Restaurant();
                $restaurant->name = $name;
                $restaurant->address = $address;
                $restaurant->save();

                foreach($operationHours as $operationHour) {
                    $restoOperationHour = new RestaurantOperationHour();
                    $restoOperationHour->restaurant_id = $restaurant->id;
                    $restoOperationHour->day = $operationHour['day'];
                    $restoOperationHour->open = $operationHour['open'];
                    $restoOperationHour->close = $operationHour['close'];
                    $restoOperationHour->is_open = $operationHour['is_open'];
                    $restoOperationHour->save();
                }

                $this->dispatch('itemSaved');

            });
        } catch (\Exception $e) {
            \Log::error('Error creating schedule master: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.restaurant.form');
    }
}
