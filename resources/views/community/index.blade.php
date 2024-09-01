@php
    if ($user_details['user_type'] == 'management') {
        $portal_type = 'management';
    } else {
        $portal_type = 'resident';
    }

    $maxCommentsToShow = 3; // Maximum number of comments to show initially
@endphp

<!DOCTYPE html>
<html lang="en">
@include($portal_type . '_components.header')
<link href="{{ asset('css/community.css') }}" rel="stylesheet">
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include($portal_type . '_components.sidebar')
            @include($portal_type . '_components.topbar')

            <!-- Page Content -->
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <div class="card">
                                <div class="card-header">Community Posts</div>

                                <div class="card-body">
                                    <!-- Create Post Form -->
                                    <form action="{{ route('community.storePost') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="3" placeholder="Share your thoughts..." required></textarea>
                                            @error('content')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Post</button>
                                    </form>
                                    <hr>

                                    <!-- Posts -->
                                    @foreach ($posts as $post)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <p class="card-text">{{ $post->content }}</p>
                                                <small class="text-muted">Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y H:i') }}</small>
                                                <hr>
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
                                                <hr>
                                            </div>
                                            <div class="card-footer">
                                                <!-- Comments -->
                                                <ul class="list-unstyled">
                                                    @php
                                                        $comments = $post->comments()->orderBy('created_at', 'asc')->take($maxCommentsToShow)->get();
                                                        $remainingCommentsCount = $post->comments()->count() - $maxCommentsToShow;
                                                    @endphp
                                                    @foreach ($comments as $comment)
                                                        <li class="media my-3">
                                                            <img src="{{ asset('images/user-avatar.png') }}" alt="User Avatar" class="mr-3">
                                                            <div class="media-body">
                                                                <p>{{ $comment->comment }}</p>
                                                                <small class="text-muted">Commented by <b>{{ $comment->user->name }}</b> on {{ $comment->created_at->format('M d, Y H:i') }}</small>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                    @if ($remainingCommentsCount > 0)
                                                        <li class="media my-3 remaining-comments" style="display: none;">
                                                            <div class="media-body">
                                                                <p class="text-muted">And {{ $remainingCommentsCount }} more comments...</p>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                                <!-- Expand Comments Button -->
                                                @if ($remainingCommentsCount > 0)
                                                    <button type="button" class="btn btn-link show-more-comments-btn">
                                                        Show more comments
                                                    </button>
                                                @endif
                                                <!-- Create Comment Form -->
                                                <form action="{{ route('community.storeComment', $post->id) }}" method="POST" style="display: none;">
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
                                        </div>
                                    @endforeach
                                    <!-- Pagination -->
                                    {{ $posts->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include($portal_type . '_components.script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show more comments button
            document.querySelectorAll('.show-more-comments-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const commentsList = button.parentNode.querySelector('.list-unstyled');
                    const remainingComments = commentsList.querySelectorAll('.remaining-comments');

                    remainingComments.forEach(comment => {
                        comment.style.display = 'block';
                    });

                    button.style.display = 'none';
                });
            });

            // Toggle comment form button
            document.querySelectorAll('.show-comment-form-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = button.parentNode.querySelector('form');

                    if (form.style.display === 'none' || form.style.display === '') {
                        form.style.display = 'block';
                    } else {
                        form.style.display = 'none';
                    }
                });
            });

            // Toggle comments section
            document.querySelectorAll('.show-more-comments-btn, .show-comment-form-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const commentSection = button.closest('.card-footer').querySelector('.list-unstyled, form');

                    if (commentSection.style.display === 'none' || commentSection.style.display === '') {
                        commentSection.style.display = 'block';
                    } else {
                        commentSection.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
