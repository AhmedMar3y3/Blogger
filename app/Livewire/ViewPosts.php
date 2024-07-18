<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostViewers;
use Livewire\Component;

class ViewPosts extends Component
{
    public $posts;
    
    public function mount()
    {
        $this->posts = Post::join('users','users.id','=','posts.user_id')
        ->orderBy('created_at','desc')
        ->get(['users.name','users.id as followedId','posts.*']);
    }
    public function addViewers($postId){
        $addviewer = new PostViewers();
        $addviewer->user_id = auth()->user()->id;
        $addviewer->post_id = $postId;
        $addviewer->save();
    }
    public function render()
    {
        return view('livewire.view-posts');
    }
}
