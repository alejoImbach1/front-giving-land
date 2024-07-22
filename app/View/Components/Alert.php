<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */

    public string $bg = '', $borderColor = '', $textColor = '';
    public function __construct(
        public string $type = '',
        public string $message = ''
    ) {
        switch ($type) {
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
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'blade'
        <div class="fixed top-14 left-14 border-l-4 p-4 z-50 rounded {{$bg}} {{$borderColor}}" {{$attributes}}>
            <p class="{{$textColor}}">{{$message}}</p>
        </div>
        <script>
            divAlert = document.getElementById('div_alert');
            setTimeout(() => {
                divAlert.remove();
            }, 2000);
        </script>
        blade;
    }
}
