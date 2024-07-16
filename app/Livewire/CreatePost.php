<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;
    public $post_title = '';
    public $content = '';
    public $photo;
    

    // function to save post
    public function save(){
        $this->validate([
            'post_title' => 'required',
            'content' => 'required',
             'photo' => 'required',
        ]);
         $photo_name = md5($this->photo . microtime()).'.'.$this->photo->extension();
         $this->photo->storeAs('public/images', $photo_name);
        
        $createPost = new Post;
        $createPost->post_title = $this->post_title;
        $createPost->content = $this->content;
        $createPost->photo = $photo_name;
        $createPost->user_id = auth()->user()->id;
        $createPost->save();
       

       $this->post_title = '';
       $this->content = '';
       //session()->flash('message', 'The post was successfully created!');
       $this->redirect('/myposts',navigate: true);
    }
    public function render()
    {
        return view('livewire.create-post');
    }
}