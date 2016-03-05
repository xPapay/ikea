 <div class="row">
        <div class="col-sm-1">
            <div class="thumbnail">
                <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
            </div><!-- /thumbnail -->
        </div><!-- /col-sm-1 -->

        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{ $comment->owner->name }}</strong>
                    <span class="text-muted">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->diffForHumans() }}</span>
                    <span class="text-muted">({{ Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }})</span>
                </div>
                <div class="panel-body">
                    {{ $comment->content }}
                </div><!-- /panel-body -->
            </div><!-- /panel panel-default -->
        </div><!-- /col-sm-5 -->
 </div>