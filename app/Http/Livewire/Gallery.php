<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
class Gallery extends Component
{
    public $images;
    public function render()
    {   
        $images = DB::table('galleries')->orderBy('order_position', 'ASC')->get();
        return view('livewire.gallery', compact('images'));
    }

    public function updateTaskOrder($images){
        foreach($images as $img){
            DB::table('galleries')->where('id', $img['value'])->update(['order_position'=>$img['order']]);
        }

        return redirect('content/gallery')->with('success', 'Successfully item position changed');

    }
}
