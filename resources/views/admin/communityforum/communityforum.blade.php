<x-app-layout>
@section('title', 'Community Forum')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="header py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold">
        <h4><i class="fa-regular fa-comments"></i> Community Forum</h4>
    </div>

    <div class="max-w-full px-4 mx-auto mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <div id="postModal" class="modal">
            <div class="modal-content">
                <h4 class="text-blue-800 font-bold text-2xl mb-3">Post a New Topic</h4>
                <form action="{{ route('admin.communityforum.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <textarea type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" id="topic" name="topic" placeholder="What's on your mind?" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="block text-sm font-medium text-gray-700">Add an image (optional)</label>
                        <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                        ">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 mr-2">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white">Post Topic</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="actions px-6 py-4 flex justify-between items-center">
            <button onclick="openModal()" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white">
                <i class="fa-solid fa-plus"></i> Add Post
            </button>

            <form action="{{ route('admin.communityforum') }}" method="GET" class="w-64">
                <div class="relative">
                    <input type="text" name="search" placeholder="Search by name or topic..." class="w-full h-10 px-3 pr-10 rounded-full text-sm focus:ring-2 border border-gray-300 focus:outline-none focus:border-blue-500">
                    <button type="submit" class="absolute inset-y-0 right-0 px-3 flex items-center bg-blue-500 rounded-r-full text-white hover:bg-blue-600">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg p-5 shadow-md mb-5">
            @foreach ($communityforums as $communityforum)
                <div class="bg-white rounded-lg p-4 mb-5 shadow-md transition-transform duration-300 ease-in-out hover:translate-y-[-5px] hover:shadow-lg">
                    <div class="flex items-center justify-between mb-2.5">
                        <div>
                            <span class="text-blue-800 font-bold">{{ $communityforum->user->name }}</span>
                            <span class="text-gray-500">{{ $communityforum->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div class="mt-2.5 text-sm leading-6">
                        <div class="editing-content" id="edit-form-{{ $communityforum->id }}" style="display: none;">
                            <form method="post" action="{{ route('admin.updatedCommunityforum', $communityforum->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" id="topic" name="topic" placeholder="What's on your mind?" value="{{ old('topic', $communityforum->topic) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="block text-sm font-medium text-gray-700">Update image (optional)</label>
                                    <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100
                                    ">
                                </div>
                                <div class="flex mb-3">
                                    <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white">Update</button>
                                    <button type="button" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 ml-2" onclick="cancelEdit('{{ $communityforum->id }}')">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <div class="non-editing-content" id="non-edit-form-{{ $communityforum->id }}" style="display: block;">
                            <p>{{ $communityforum->topic }}</p>
                            @if($communityforum->image_path)
                            <div class="mt-3">
                                <img src="{{ asset($communityforum->image_path) }}" alt="Forum post image" class="max-w-full h-auto max-h-96 rounded-lg shadow-md">
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-2.5 flex justify-end">
                        <button class="text-sm rounded-full px-3 py-1.5 bg-gray-100 text-gray-800 border border-gray-300 transition-colors duration-300 ease-in-out ml-2.5 hover:bg-gray-200" onclick="toggleComments('{{ $communityforum->id }}')"><i class="fa-regular fa-message"></i> Comments</button>
                        @if(Auth::id() === $communityforum->user_id || Auth::user()->is_admin)
                            <button class="text-sm rounded-full px-3 py-1.5 bg-gray-100 text-gray-800 border border-gray-300 transition-colors duration-300 ease-in-out ml-2.5 hover:bg-gray-200" onclick="editTopic('{{ $communityforum->id }}')"><i class="fa-solid fa-pen"></i> Edit</button>
                            <form method="post" action="{{ route('admin.deleteCommunityforum', $communityforum->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm rounded-full px-3 py-1.5 bg-gray-100 text-gray-800 border border-gray-300 transition-colors duration-300 ease-in-out ml-2.5 hover:bg-gray-200" onclick="return confirm('Are you sure you want to delete this post?')"><i class="fa-regular fa-trash-can"></i> Delete</button>
                            </form>
                        @endif
                    </div>

                    <!-- Comments Section -->
                    <div id="comments-section-{{ $communityforum->id }}" class="comments-section hidden">
                        <!-- Add Comment Form -->
                        <div class="add-comment-form mt-5">
                            <form action="{{ route('admin.addComment', $communityforum->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center mb-3">
                                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" id="comment" name="comment" placeholder="Add a comment..." required></textarea>
                                    <div class="flex-shrink-0">
                                        <button type="submit" class="px-4 py-5 rounded bg-blue-500 hover:bg-blue-700 text-white">Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @foreach ($communityforum->comments as $comment)
                            <div class="bg-white rounded-lg p-5 shadow-md mb-5 transition-transform duration-300 ease-in-out hover:translate-y-[-5px] hover:shadow-lg">
                                <div class="flex items-center justify-between mb-2.5">
                                    <div>
                                        <span class="text-blue-800 font-bold">{{ $comment->user->name }}</span>
                                        <span class="text-gray-500">{{ $comment->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="mt-2.5 text-sm leading-6">
                                    <div class="editing-content" id="edit-comment-form-{{ $comment->id }}" style="display: none;">
                                        <form method="post" action="{{ route('admin.updatedComment', $comment->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" id="comment" name="comment" placeholder="Edit your comment" value="{{ old('comment', $comment->comment) }}" required>
                                            </div>
                                            <div class="update-cancel-buttons">
                                                <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white">Update</button>
                                                <button type="button" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800" onclick="cancelEditComment('{{ $comment->id }}')">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="non-editing-content" id="non-edit-comment-form-{{ $comment->id }}" style="display: block;">
                                        <p>{{ $comment->comment }}</p>
                                    </div>
                                </div>
                                <div class="mt-2.5 flex justify-end">
                                    @if(Auth::id() === $comment->user_id || Auth::user()->is_admin)
                                        <button class="text-sm rounded-full px-3 py-1.5 bg-gray-100 text-gray-800 border border-gray-300 transition-colors duration-300 ease-in-out ml-2.5 hover:bg-gray-200" onclick="editComment('{{ $comment->id }}')"><i class="fa-solid fa-pen"></i> Edit</button>
                                        <form method="post" action="{{ route('admin.deleteComment', $comment->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm rounded-full px-3 py-1.5 bg-gray-100 text-gray-800 border border-gray-300 transition-colors duration-300 ease-in-out ml-2.5 hover:bg-gray-200" onclick="return confirm('Are you sure you want to delete this comment?')"><i class="fa-regular fa-trash-can"></i> Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            {{ $communityforums->links() }}
        </div>
    </div>

    <script>
        function toggleComments(forumId) {
            var commentsSection = document.getElementById('comments-section-' + forumId);
            commentsSection.classList.toggle('hidden');
        }

        function editTopic(forumId) {
            document.getElementById('edit-form-' + forumId).style.display = 'block';
            document.getElementById('non-edit-form-' + forumId).style.display = 'none';
        }

        function cancelEdit(forumId) {
            document.getElementById('edit-form-' + forumId).style.display = 'none';
            document.getElementById('non-edit-form-' + forumId).style.display = 'block';
        }

        function editComment(commentId) {
            document.getElementById('edit-comment-form-' + commentId).style.display  = 'block';
            document.getElementById('non-edit-comment-form-' + commentId).style.display = 'none';
        }

        function cancelEditComment(commentId) {
            document.getElementById('edit-comment-form-' + commentId).style.display = 'none';
            document.getElementById('non-edit-comment-form-' + commentId).style.display = 'block';
        }

        function openModal() {
            document.getElementById('postModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('postModal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('postModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    
</body>
</html>

</x-app-layout>