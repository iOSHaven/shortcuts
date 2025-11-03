<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PostCreate extends Component
{
    public $title;
    public $slug;
    public $markdown;

    public function render()
    {
        return view("livewire.post-create");
    }

    public function save()
    {
        $rules = [
            "title" => ["required", "string", "max:100"],
            "markdown" => ["min:20", "string", "required", "max:60000"],
        ];

        $this->validate($rules);

        $post = Post::create([
            "title" => $this->title,
            "markdown" => $this->markdown,
        ]);

        $post->authors()->syncWithoutDetaching([Auth::user()->id]);

        return redirect(route("post.edit", $post));
    }
}
