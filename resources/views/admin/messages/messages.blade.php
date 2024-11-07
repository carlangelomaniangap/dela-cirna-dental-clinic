<x-app-layout>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <div class="chat-container">
        <div class="users-list" id="users">
            <div>
                <h1><i class="fa-regular fa-comment-dots"></i> Messages</h1>
            </div>
            <form id="search-form" action="{{ route('admin.messages.search') }}" method="GET">
                <div class="relative w-full">
                    <input type="text" name="query" id="search-input" placeholder="Search" class="w-full h-10 px-3 rounded-full focus:ring-2 border border-gray-300 focus:outline-none focus:border-blue-500">
                    <button type="submit" class="absolute top-0 end-0 p-2.5 pr-3 text-sm font-medium h-full text-white bg-blue-700 rounded-e-full border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </form>
            <br>
            <div id="user-list-container">
                @foreach ($usersWithLastMessage as $user)
                    <div class="user-item" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                        <div>
                            {{ $user->name }}
                            <div class="recent-message" id="recent-{{ $user->name }}">{{ $user->last_message }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="chat-box" id="chat-box">
            <div id="selected-user-box" class="selected-user-box" style="display: none;">
                <div class="flex items-center space-x-2">
                    <button id="back-button">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <p id="selected-user-name"></p>
                </div>
            </div>

            @foreach ($users as $user)
                @if ($user->usertype !== 'dentistrystudent')
                    <div id="chat-panel-{{ $user->name }}" class="chat-messages" style="display: none;">
                        @foreach ($messages as $message)
                            @if ($message->sender_id == auth()->id() && $message->recipient_id == $user->id)
                                <div class="admin">
                                    <p>You</p>
                                    <p class="text-justify">{{ $message->message }}</p>
                                </div>
                            @elseif ($message->sender_id == $user->id && $message->recipient_id == auth()->id())
                                <div class="others">
                                    <p>{{ $user->name }}</p>
                                    <p class="text-justify">{{ $message->message }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach

            <form method="post" action="{{ route('admin.messages.store') }}" class="chat-input" id="chat-form">
                @csrf
                <input type="hidden" id="recipient_id" name="recipient_id" value="">
                <input placeholder="Type your message..." rows="3" type="text" class="form-control" id="message" name="message" required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backButton = document.getElementById('back-button');
            const usersList = document.getElementById('users');
            const chatBox = document.getElementById('chat-box');
            const selectedUserName = document.getElementById('selected-user-name');
            const recipientIdInput = document.getElementById('recipient_id');
            
            const userItems = document.querySelectorAll('.user-item');

            // Show users list and hide chat box by default on mobile view
            if (window.innerWidth <= 768) {
                usersList.classList.add('show');
                chatBox.classList.add('hide');
            } else if (userItems.length > 0) {
                // Select the first user by default on larger screens
                const firstUser = userItems[0];
                firstUser.classList.add('selected');
                const username = firstUser.getAttribute('data-username');
                const userid = firstUser.getAttribute('data-userid');

                selectedUserName.textContent = username;
                recipientIdInput.value = userid;

                usersList.classList.remove('show');
                chatBox.classList.remove('hide');

                const chatPanel = document.getElementById(`chat-panel-${username}`);
                if (chatPanel) {
                    chatPanel.style.display = 'block';
                    chatPanel.scrollTop = chatPanel.scrollHeight; // Scroll to the bottom
                }
                document.getElementById('selected-user-box').style.display = 'block';
            }

            // Back button functionality for mobile
            backButton.addEventListener('click', function() {
                usersList.classList.add('show');
                chatBox.classList.add('hide');
            });

            // Select user and switch to chat panel when a user is clicked
            userItems.forEach(item => {
                item.addEventListener('click', function() {
                    userItems.forEach(user => user.classList.remove('selected'));
                    item.classList.add('selected');

                    const username = item.getAttribute('data-username');
                    const userid = item.getAttribute('data-userid');

                    selectedUserName.textContent = username;
                    recipientIdInput.value = userid;

                    usersList.classList.remove('show');
                    chatBox.classList.remove('hide');

                    document.querySelectorAll('.chat-messages').forEach(panel => {
                        panel.style.display = 'none';
                    });

                    const chatPanel = document.getElementById(`chat-panel-${username}`);
                    if (chatPanel) {
                        chatPanel.style.display = 'block';
                        chatPanel.scrollTop = chatPanel.scrollHeight; // Scroll to the bottom
                    }

                    document.getElementById('selected-user-box').style.display = 'block';
                });
            });

            document.getElementById('search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                let searchQuery = document.getElementById('search-input').value.toLowerCase();
                userItems.forEach(item => {
                    let username = item.dataset.username.toLowerCase();
                    item.style.display = username.includes(searchQuery) ? 'block' : 'none';
                });
            });

            document.getElementById('chat-form').addEventListener('submit', function(e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);

                let newMessage = {
                    sender_id: {{ auth()->id() }},
                    recipient_id: formData.get('recipient_id'),
                    message: formData.get('message'),
                    created_at: new Date().toISOString()
                };
                addMessageToChat(newMessage);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Message sent successfully');
                    } else {
                        console.error('Error sending message:', data.error);
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });

                form.reset();
            });
            
        });

        function addMessageToChat(message) {
            let chatPanel = document.getElementById(`chat-panel-${document.querySelector('.user-item.selected').dataset.username}`);
            if (chatPanel) {
                let messageDiv = document.createElement('div');
                messageDiv.className = message.sender_id === {{ auth()->id() }} ? 'admin' : 'others';
                messageDiv.innerHTML = `
                    <p>${message.sender_id === {{ auth()->id() }} ? 'You' : document.querySelector('.user-item.selected').dataset.username}</p>
                    <p>${message.message}</p>
                `;
                chatPanel.appendChild(messageDiv);
                chatPanel.scrollTop = chatPanel.scrollHeight; // Scroll to the bottom after adding the message
            }
        }
    </script>

</body>
</html>

@section('title')
    Messages
@endsection

</x-app-layout>
