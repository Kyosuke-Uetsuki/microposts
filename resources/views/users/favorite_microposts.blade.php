@if (count($favorites) > 0)
    <ul class="list-unstyled">
        @foreach ($favorites as $favorite)
            <li class="media">
                {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div class="row">
                        {{-- ユーザ詳細ページへのリンク --}}
                        <p>{!! link_to_route('users.show', $favorite->user->name, ['user' => $favorite->user->id],["class"=>"col-4"]) !!}</p>
                        <span class="text-muted">posted at {{ $favorite->created_at }}</span>
                    </div>
                    <div class="">
                        <!--{{-- お気に入りの投稿 --}}-->
                        {{ $favorite->content }}
                        <div class="d-flex">
                            <div class="">
                                @if (Auth::id() == $favorite->user_id)
                                    {{-- 投稿削除ボタンのフォーム --}}
                                    {!! Form::open(['route' => ['microposts.destroy', $favorite->id], 'method' => 'delete']) !!}
                                        {!! Form::submit('Delete', ['class' => ' btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </div>
                            <div>
                                @if(Auth::user()->being_favorite($favorite->id))
                                    {!! Form::open(["route" => ["favorites.unfavorite", $favorite->id], "method" => "delete"]) !!}
                                        {!! Form::submit("Unfavorite",["class" => " btn btn-warning btn-sm"])!!}
                                    {!! Form::close() !!}
                                @else
                                    {!! Form::open(["route" => ["favorites.favorite", $favorite->id]]) !!}
                                        {!! Form::submit("Favorite",["class" => "btn btn-success btn-sm"])!!}
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
{{-- ページネーションのリンク --}}
    {{ $favorites->links() }}
@endif