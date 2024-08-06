<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Alert extends Component
{
    public $displayed = false;

    public string $type;
    public string $message;
    public string $bg;
    public string $borderColor;
    public string $textColor;

    #[On('alert-sent')]
    public function display($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
        switch ($this->type) {
            case 'success':
                $this->bg = 'bg-green-200';
                $this->borderColor = 'border-green-500';
                $this->textColor = 'text-green-800';
                break;

            case 'warning':
                $this->bg = 'bg-yellow-100';
                $this->borderColor = 'border-yellow-400';
                $this->textColor = 'text-yellow-700';
                break;

            case 'danger':
                $this->bg = 'bg-red-200';
                $this->borderColor = 'border-red-500';
                $this->textColor = 'text-red-900';
                break;
            default:
                # code...
                break;
        }
        $this->displayed = true;
        $this->dispatch('alert-shown');
    }

    #[On('alert-shown')]
    public function close()
    {
        sleep(2);
        $this->displayed = false;
    }

    public function render()
    {
        return <<<'blade'
        <div @class(['fixed top-14 left-14 border-l-4 p-4 z-50 rounded '.$bg.' '.$borderColor, 'hidden' => !$displayed])>
            <p class ="{{$textColor}}">{{$message}}</p>
        </div>
        blade;
    }
}
