 <div class="row">
        <div class="col-sm-1">
            <div class="thumbnail">
                <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
            </div><!-- /thumbnail -->
        </div><!-- /col-sm-1 -->

        <div class="col-sm-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($comment->owner)
                        <strong>{{ $comment->owner->name }}</strong>
                    @endif
                    <span class="text-muted">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->diffForHumans() }}</span>
                    <span class="text-muted">({{ Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }})</span>
                </div>
                <div class="panel-body">
                    {{ $comment->content }}
                    @if (count($comment->photos) > 0)
                        @foreach($comment->photos->chunk(3) as $row)
                            <div class="row>">
                                @foreach($row as $photo)
                                    <div class="col-lg-4">
                                        <a href="/{{ $photo->path }}" data-lity>
                                            <img src="/{{ $photo->thumbnail_path }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                    @if (count($comment->files) > 0)
                        @foreach($comment->files->chunk(3) as $row)
                            <div class="row>">
                                @foreach($row as $file)
                                    <div class="col-lg-4">
                                        <a href="{{ asset($file->path) }}">
                                            {{ substr($file->name, 11) }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div><!-- /panel-body -->
            </div><!-- /panel panel-default -->
        </div><!-- /col-sm-5 -->
 </div>