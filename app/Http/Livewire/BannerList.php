<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Banner;

class BannerList extends Component
{

    public $banners;
    public function render()
    {   
        $banners = banner::orderBy('order_position', 'ASC')->get();
        return view('livewire.banner-list', compact('banners'));
    }

    public function updateTaskOrder($banners){
        foreach($banners as $ban){
            banner::find($ban['value'])->update(['order_position'=>$ban['order']]);
        }

        return redirect('admin/banners')->with('success', 'Successfully item position changed');

    }

    
}
