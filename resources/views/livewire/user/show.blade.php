<div>
    <x-show-user-info>
        <x-slot name="title"> {{ __('Ndjeksat') }} </x-slot>
        <x-slot name="id"> showUserFollowing </x-slot>
        @forelse ($follows as $follower)
            {{ $follower->user->username }}
        @empty
            Nuk ka
        @endforelse
    </x-show-user-info>

    <x-show-user-info>
        <x-slot name="title"> {{ __('Ndjet') }} </x-slot>
        <x-slot name="id"> showUserFollowers </x-slot>
        @forelse ($followings as $follower)
            {{ $follower->following }}
        @empty
            Nuk ka
        @endforelse
    </x-show-user-info>

    {{-- @foreach ($user->followers as $item)
    {{ $item   }}
@endforeach --}}

    <div class="user-profile">
        <div class="container m-auto mt-5 d-flex justify-content-center">
            <div class="card shadow bg-light p-3 ">
                <div class="media d-flex align-items-center">
                    {{-- <img src="assets/img/user/AlpetGBlogUser.60c38af32e7f04.43411620.jpg " class="rounded-circle" width="155"> --}}
                    <img src="{{ $user->profile_photo_url }}" class="rounded-circle" height="155" width="155">
                    <div class="ml-3 w-100">
                        <h4 class="mb-1 mt-1"> {{ $user->name }} {{ $user->mbiemri }} </h4> <span
                            class="span_username">@</span><span class="span_username">{{ $user->username }}</span>

                        <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                            <div class="d-flex flex-column">
                                <span class="articles">Postime</span>
                                <span class="number">{{ $user->post()->count() }}</span>
                            </div>
                            <a href="" data-bs-toggle="modal" data-bs-target="#showUserFollowing">
                            <div class="d-flex flex-column">
                                <span class="articles">Ndjek</span>
                                <span class="number">{{ $follows->count() }}</span>
                            </div>
                            </a>
                            <a href="" data-bs-toggle="modal" data-bs-target="#showUserFollowers">
                                <div class="d-flex flex-column">
                                    <span class="articles">Ndjekës</span>
                                    <span class="number">{{ $user->followers()->count() }}</span>
                                </div>
                            </a>
                        </div>

                        <div class="button mt-2 d-flex flex-row align-items-center">
                            @if (auth()->check())
                                @if (auth()->user()->id == $user->id)
                                    <a class="btn btn-sm btn-outline-success w-100 ml-2"
                                        href="{{ url('/user/profile') }}">Edit</a>
                                @elseif ($user->isFollow(auth()->user()))
                                    <button class="btn btn-sm btn-outline-success w-100 ml-2"
                                        wire:loading.attr='disabled' wire:click="unFollow({{ $user->id }})"
                                        type="submit">UnFollow</button>
                                @else
                                    <button class="btn btn-sm btn-success w-100 ml-2" wire:loading.attr='disabled'
                                        wire:click="follow({{ $user->id }})" type="submit">Follow</button>
                                @endif
                                &nbsp; <button class="btn btn-sm btn-outline-success w-100">Chat</button>
                            @endif
                        </div>
                        @if (auth()->guest())
                            <form method="" action="{{ route('login') }}">
                                {{-- @csrf --}}
                                <button class="btn btn-sm btn-success w-100 ml-2" type="submit">Follow</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- @if (auth()->user()->id == $user->id)
    Edit
    @elseif ($user->is_follow())
    <button wire:click="unFollow({{$user->id}})" type="submit"><i class="fas fa-thumbs-up pr-3"></i>UnFollow</button>
    @else
    <button wire:click="follow({{$user->id}})" type="submit"><i class="far fa-thumbs-up pr-3"></i>Follow</button>
    @endif --}}

    {{-- {{ $user->followers()->user_id }} --}}

    {{-- chek if user have follow this user --}}
    {{-- {{ dd($user->followers()) }} --}}



    {{-- Ceck if user have follow this user --}}
    {{-- @if (auth()->check() && auth()->user()->id == $user->id)
        Edit
    @endif --}}


    <h1>Post</h1>
    @forelse ($user->post as $post)

        <h1>Titulli : {{ $post->title }}</h1>
        User : <a href="{{ route('user.show', $post->user->username) }}">{{ $post->user->username }}</a>,<br>
        Pershkrimi : {{ $post->body }},<br>
        Categorys : <livewire:category.postcategory :id="$post->id">,<br>

            Photo : <img src="{{ url('storage/app/' . $post->photo) }}" alt="" /> ,<br>
            saves : {{ $post->saves()->count() }},<br>
            Likes : {{ $post->likes()->count() }},<br>
            comments : {{ $post->comments()->count() }},<br>
            views : {{ $post->views }},<br>
            U krijoa me : {{ $post->created_at->diffForHumans() }},<br>

            @if (auth()->check())

                @if (!$post->isLikedByUser(Auth::user()))
                    <button wire:click.prevent="like({{ $post->id }})" type="button"><i
                            class="far fa-thumbs-up pr-3"></i>Like</button>
                @else
                    <button wire:click.prevent="unLike({{ $post->id }})" type="button"><i
                            class="fas fa-thumbs-up pr-3"></i>UnLike</button>
                @endif

                @if (!$post->isSavedByUser(Auth::user()))
                    <button wire:click="save({{ $post->id }})" type="submit"><i
                            class="far fa-thumbs-up pr-3"></i>Save</button>
                @else
                    <button wire:click="unSave({{ $post->id }})" type="submit"><i
                            class="fas fa-thumbs-up pr-3"></i>UnSave</button>
                @endif

                @if (auth()->check() && auth()->user()->id == $user->id)
                    <button>Ndrysho</button> <button>Fshije</button>
                @endif

            @endif

        @empty
            Nuk ka postime
    @endforelse
</div>
