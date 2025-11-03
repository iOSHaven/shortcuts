<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostEdit extends Component
{
    public Post $post;
    public $title;
    public $markdown;
    public $slug;
    public $originalSlug;

    public function mount()
    {
        $this->title = $this->post->title;
        $this->markdown = $this->post->markdown;
        $this->slug = $this->post->slug;
        $this->originalSlug = $this->post->slug;
    }

    public function render()
    {
        return view("livewire.post-edit");
    }

    public function save()
    {
        $rules = [
            "title" => ["required", "string", "max:100"],
            "markdown" => ["min:20", "string", "required", "max:60000"],
        ];

        if (auth()->user()->can("modify-slugs")) {
            $rules["slug"] = [
                "required",
                "string",
                "max:100",
                "unique:posts,slug," . $this->post->id,
            ];
        }

        $this->validate($rules);

        $this->post->title = $this->title;
        $this->post->slug = $this->slug;
        $this->post->markdown = $this->markdown;
        $this->post->save();

        if ($this->originalSlug !== $this->post->slug) {
            redirect(route("post.edit", $this->post));
        }
    }
}
