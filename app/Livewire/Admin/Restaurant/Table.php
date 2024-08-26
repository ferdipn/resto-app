<?php

namespace App\Livewire\Admin\Restaurant;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Restaurant;
use Carbon\Carbon;

class Table extends Component
{

    use WithPagination;

    public $today;
    public $search = '';
    public $filterByDate = '';
    private $isOpenModal = false;
    private $formatDate = '';
    private $formatTime = '';
    
    protected $listeners = ['searchUpdated', 'itemSaved' => 'render'];
    protected $paginationTheme = 'tailwind';

    protected $queryString = ['search'];


    public function openModal()
    {
        $this->isOpenModal = true;
    }

    public function closeModal()
    {
        $this->isOpenModal = false;
    }

    public function mount()
    {
        $this->today = Carbon::now()->format('M/D/Y');
    }

    public function updatingSearch($value)
    {
        $this->resetPage();
    }

    public function updatingFilterByDate($value)
    {
        if ($value !== '') {
            $formatDate = Carbon::parse($value)->format('N');
            $formatTime = Carbon::parse($value)->format('H:i:s');
    
            $this->formatDate = $formatDate;
            $this->formatTime = $formatTime;
        }
        $this->resetPage();
    }

    public function render()
    {
        $restaurants = Restaurant::with('operationHours');
        
        if ($this->search) {
            $restaurants->whereRaw("LOWER(name) LIKE ?", "%".trim(strtolower($this->search))."%");
        }

        if ($this->filterByDate) {
            $selectedDate = $this->formatDate;
            $selectedtime = $this->formatTime;
            $restaurants->whereHas('operationHours', function($q) use ($selectedDate, $selectedtime) {
                $q->where('day', $selectedDate)
                    ->whereTime('open', '<=', $selectedtime)
                    ->whereTime('close', '>=', $selectedtime)
                    ->where('is_open', true);
            });
        }
        $restaurants = $restaurants->paginate(10);
        
        foreach ($restaurants as $indexResto => $restaurant) {
            $hoursString = "";
            $latestDataArray = [];

            foreach ($restaurant->operationHours as $i => $operationHour) {
                $latestData = end($latestDataArray);
                
                if (empty($latestData)) {
                    $newArray = [
                        'day' => [$operationHour->day],
                        'label' => [$this->getDayName($operationHour->day)],
                        'open' => $operationHour->open,
                        'close' => $operationHour->close
                    ];
                    $latestDataArray[] = $newArray;
                } else {
                    $latestDay = end($latestData['day']);
                    
                    if ($operationHour->day - $latestDay === 1) {
                        if ($latestData['open'] === $operationHour->open
                            && $latestData['close'] === $operationHour->close
                        ) {
                            $latestData['day'][] = $operationHour->day;
                            $latestData['label'][] = $this->getDayName($operationHour->day);
                            $latestDataArray[count($latestDataArray) - 1] = $latestData;
                        } else {
                            $newArray = [
                                'day' => [$operationHour->day],
                                'label' => [$this->getDayName($operationHour->day)],
                                'open' => $operationHour->open,
                                'close' => $operationHour->close
                            ];
                            $latestDataArray[] = $newArray;
                        }
                    } else {
                        $newArray = [
                            'day' => [$operationHour->day],
                            'label' => [$this->getDayName($operationHour->day)],
                            'open' => $operationHour->open,
                            'close' => $operationHour->close
                        ];
                        $latestDataArray[] = $newArray;
                    }
                }
            }

            $stringDay = '';

            foreach ($latestDataArray as $index => $latestA) {

                if ($index > 0) {
                    $stringDay .= "\n/ ";
                }
                $newString = "{$latestA['label'][0]}";
                if (count($latestA['day']) > 1) {
                    $latestB = end($latestA['label']);
                    $newString .= " - {$latestB}";
                }

                $latestDataOpen =  Carbon::createFromFormat('H:i:s', $latestA['open'])->format('h:i a') ;
                $latestDataClose = Carbon::createFromFormat('H:i:s', $latestA['close'])->format('h:i a') ;; 

                $newString .= " {$latestDataOpen} - {$latestDataClose}";

                $stringDay .= $newString;
            }

            $restaurants[$indexResto]['schedule_label'] = $stringDay;
        }

        return view('livewire.admin.restaurant.table', [
            'data' => $restaurants
        ]);
    }

    private function getDayName($day)
    {
        $days = [
            1 => 'Mon',
            2 => 'Tue',
            3 => 'Wed',
            4 => 'Thu',
            5 => 'Fri',
            6 => 'Sat',
            7 => 'Sun',
        ];

        return $days[$day] ?? 'Unknown';
    }

}
