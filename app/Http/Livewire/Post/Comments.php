<?php

namespace App\Http\Livewire\Post;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\RateLimiter;
use App\Traits\WithMoreLess;

class Comments extends Component
{
    use AuthorizesRequests, WithMoreLess;
    public $post,
        //Komenti
        $Komenti = [], $editKommeti = [], $comment_id,
        // Reply
        $Repley = [],
        $per_page = 7;

    protected $rules = [
        'Komenti' => 'required|min:3|max:1000',
        // 'Repley' => 'required|min:3',
    ];
    /**
     * @param  post_id $id
     */
    public function mount(int $id)
    {
        $this->post = Post::findOrFail($id);
    }

    /** 
     * i heq te thenat e inputit
     */
    public function blankFild()
    {
        $this->Komenti = '';
        $this->Repley = '';
    }

    public function blankFildRepley()
    {
        $this->Repley = '';
    }

    /****************** Komenti ******************/
    /**
     * Store comment
     */
    public function addCommnet()
    {

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $executed = RateLimiter::attempt(
            'make-comment:' . auth()->user()->id,
            $perMinute = 4, //4 komente per minut
            function () {
                $this->validate();
                Comment::create([
                    'body' => $this->Komenti,
                    'user_id' => auth()->user()->id,
                    'post_id' =>   $this->post->id,
                ]);
                $this->blankFild();
                $this->emit('addComment');
            }
        );
        if (!$executed) {
            $seconds = RateLimiter::availableIn('make-comment:' . auth()->user()->id);
            session()->flash('success', 'U lutem prisni ' . $seconds . ' sekonda para se komentoni perseris');
        }
    }

    /**
     * E Fshin komentin
     *
     * @param  int  $id
     */

    public function deleteCommnet(int $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        //check if the user is the owner of the comment
        if (($this->post->user_id == auth()->user()->id) || (auth()->user()->id == $this->post->comments->where('id', $id)->first()->user_id)) {
            $this->post->comments()->where('id', $id)->delete();
        }
    }
    /**
     * E tregon se kush eshte  komenti
     *
     * @param  int  $id
     */
    public  function editComment(int $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->id == $this->post->user_id) {
            $this->post->comments()->where('id', $id)->update(['body' => $this->Komenti]);
            $this->blankFild();
        }
    }

    /**
     * E editon komentin
     *
     * @param  int  $id
     */
    public function updateCommnet(int $id)
    {
        $commnet = $this->post->comments()->where('id', $id)->first();
        $this->Komenti = $commnet->body;
    }

    /****************** Reply ******************/
    /**
     * E Shton Reply
     *
     * @param  int  $ids
     */
    public function addReply(int $ids)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $this->comment_id = $ids;
        $executed = RateLimiter::attempt(
            'make-reply:' . auth()->user()->id,
            $perMinute = 2,
            function () {
                $this->validate(['Repley' => 'required|min:3|max:1000']);
                CommentReply::create([
                    'comment_id' => $this->comment_id,
                    'user_id' => auth()->user()->id,
                    'body' => $this->Repley,
                ]);
                $this->blankFild();
            }
        );
        if (!$executed) {
            $seconds = RateLimiter::availableIn('make-reply:' . auth()->user()->id);
            session()->flash('success', 'U lutem prisni ' . $seconds . ' sekonda para se ta ktheni komentin');
        }
    }

    /**
     * E Fshin reply
     *
     * @param  int  $id
     */
    public function deleteReply(int $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $comment = CommentReply::where('id', $id);
        //delet reply
        if (($this->post->user_id == auth()->user()->id) || (auth()->user()->id == $comment->first()->user_id)) {
            $comment->delete();
        }
    }
    /**
     * Live Time Validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $count = Comment::where('post_id', $this->post->id)->count() + CommentReply::with(['comment' => fn ($q) => $q->where('post_id', $this->post->id)])->count();
        $comment = Comment::select('id', 'post_id',  'user_id',  'body')
            ->where('post_id', $this->post->id)
            ->orderBy('id', 'desc')
            ->paginate($this->per_page_moreless);
        // dd($this->post->comments()->comment->id);
        //get comment id from $this->post
        // $comment_id = CommentReply::pluck('comment_id')->toArray(); 
        return view('livewire.post.comments', [
            'comments' => $comment,
            // 'replies' => Comment::where('id', $comment_id)->get(),
            'commnets_count' => $count,
        ]);
    }
}
