<div>
    @if (auth()->check())

        @if (!$post->isLikedByUser(auth()->user()))
            <button class="btn btn-outline-dark" wire:click.prevent="like({{ $post->id }})" type="submit">
                <i class="far fa-thumbs-up"></i>&nbsp; Like
            </button>
        @else
            <button class="btn btn-outline-dark" wire:click.prevent="unLike({{ $post->id }})" type="submit"><i
                    class="fas fa-thumbs-up"></i>&nbsp; UnLike</button>
        @endif

        @if (!$post->isSavedByUser(auth()->user()))
            <button class="btn btn-outline-dark" wire:click.prevent="save({{ $post->id }})" type="submit"><i
                    class="far fa-bookmark"></i>&nbsp; Save</button>
        @else
            <button class="btn btn-outline-dark" wire:click.prevent="unSave({{ $post->id }})" type="submit"><i
                    class="fas fa-bookmark"></i>&nbsp; UnSave</button>
        @endif

    @endif

    @if (auth()->guest())
        <form action="{{ route('login') }}">
            <button class="btn btn-outline-dark" type="submit">
                <i class="far fa-thumbs-up"></i>&nbsp; Like </button>
            <button class="btn btn-outline-dark" type="submit">
                <i class="far fa-bookmark"></i>&nbsp; Save</button>
        </form>
    @endif
    <div class="single_post p-2 card shadow-sm bg-light">
        <div class="single_post_info">
            <img src="{{ asset('storage/' . $post->photo) }}" class="img-fluid" alt="{{ $post->title }}"
                style="width:900px;height:380px" loading="lazy">
            <div class="single_post_info_show">
                <ul>
                    <li>
                        <a href="">
                            <i class="far fa-eye fa-x2"></i>{{ $post->views }}
                            <i class="far fa-thumbs-up"></i>{{ $post->likes()->count() }}
                            <i class="far fa-bookmark"></i>{{ $post->saves()->count() }}
                            <i class="far fa-user fa-x2"></i>{{ $post->user->username }}
                            <i class="far fa-calendar-alt"></i> {{ $post->created_at->diffForHumans() }}
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <h1>{{ $post->title }}</h1>

        <p class="p-1"> {{ $post->body }} </p>
    </div>
</div>
