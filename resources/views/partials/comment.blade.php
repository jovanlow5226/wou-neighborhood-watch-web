@foreach ($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">{{ $post->content }}</p>
            <small class="text-muted">Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y H:i') }}</small>
            <hr>
            <!-- Top Comments -->
            <ul class="list-unstyled top-comments">
                @foreach ($post->topComments as $comment)
                    <li class="media my-3">
                        <img src="{{ asset('images/user-avatar.png') }}" alt="User Avatar" class="mr-3">
                        <div class="media-body">
                            <p>{{ $comment->comment }}</p>
                            <small class="text-muted">Commented by {{ $comment->user->name }} on {{ $comment->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </li>
                @endforeach
            </ul>
            <!-- Remaining Comments (Hidden by default) -->
            <ul class="list-unstyled remaining-comments" style="display: none;">
                @foreach ($post->remainingComments as $comment)
                    <li class="media my-3">
                        <img src="{{ asset('images/user-avatar.png') }}" alt="User Avatar" class="mr-3">
                        <div class="media-body">
                            <p>{{ $comment->comment }}</p>
                            <small class="text-muted">Commented by {{ $comment->user->name }} on {{ $comment->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </li>
                @endforeach
            </ul>
            <!-- Show More Button -->
            @if ($post->remainingComments->count() > 0)
                <button class="btn btn-link show-more-btn" data-post-id="{{ $post->id }}">Show More Comments</button>
            @endif
            <!-- Create Comment Form -->
            <form action="{{ route('community.storeComment', $post->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" rows="1" placeholder="Add a comment..." required></textarea>
                    @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-secondary btn-sm">Comment</button>
            </form>
        </div>
        <div class="card-footer">
            <div class="action-buttons">
                <!-- Like Button -->
                <form action="{{ route('community.likePost', $post->id) }}" method="POST">
                    @csrf
                    @php
                        $liked = $post->isLikedBy(auth()->user());
                    @endphp
                    <button type="submit" class="btn btn-sm {{ $liked ? 'btn-liked' : '' }}">
                        <i class="far fa-thumbs-up"></i> {{ $post->likes_count }} Likes
                    </button>
                </form>
                <!-- Comment Button -->
                <button type="button" class="btn btn-sm show-comment-form-btn">
                    <i class="far fa-comment"></i> Comment
                </button>
            </div>
        </div>
    </div>
@endforeach

<!-- Pagination -->
{{ $posts->links() }}

<script>
    // Script to toggle show more comments
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.show-more-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = button.getAttribute('data-post-id');
                document.querySelector(`.remaining-comments[data-post-id="${postId}"]`).style.display = 'block';
                button.style.display = 'none';
            });
        });
    });
</script>
