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
        <div class="hamburger-menu">
            <button id="toggle-users-list"><i class="fas fa-arrow-right"></i></button>
        </div>
        <div class="users-list" id="users">
            <div>
                <h1><i class="fa-regular fa-comment-dots"></i> Messages</h1>
            </div>
            <form id="search-form" action="{{ route('patient.messages.search') }}" method="GET">
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
                @foreach ($users as $user)
                    @if ($user->usertype !== 'dentistrystudent' && $user->usertype !== 'patient')
                        <div class="user-item" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                            <div>
                                {{ $user->name }}
                                <div class="recent-message" id="recent-{{ $user->name }}"></div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="chat-box" id="chat-box">
            @foreach ($users as $user)
                @if ($user->usertype !== 'dentistrystudent' && $user->usertype !== 'patient')
                    <div id="chat-panel-{{ $user->name }}" class="chat-messages" style="display: none;">
                        <!-- Chat messages for {{ $user->name }} -->
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

            <form method="post" action="{{ route('patient.messages.store') }}" class="chat-input" id="chat-form">
                @csrf
                <input type="hidden" id="recipient_id" name="recipient_id" value="">
                <input placeholder="Type your message..." rows="3" type="text" class="form-control" id="message" name="message" required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggle-users-list');
            const usersList = document.getElementById('users');
            const chatBox = document.getElementById('chat-box');

            toggleButton.addEventListener('click', function() {
                usersList.classList.toggle('show');
                chatBox.classList.toggle('hide');
            });

            const userItems = document.querySelectorAll('.user-item');
            userItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        usersList.classList.remove('show');
                        chatBox.classList.remove('hide');
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedUser = localStorage.getItem('selectedUser');
            let users = @json($users);
            let messages = @json($messages);
            let currentUserId = {{ auth()->id() }};

            function sortUsersByLastMessage() {
                users.sort((a, b) => {
                    let lastMessageA = messages.filter(m => 
                        (m.sender_id === a.id && m.recipient_id === currentUserId) || 
                        (m.sender_id === currentUserId && m.recipient_id === a.id)
                    ).pop();
                    let lastMessageB = messages.filter(m => 
                        (m.sender_id === b.id && m.recipient_id === currentUserId) || 
                        (m.sender_id === currentUserId && m.recipient_id === b.id)
                    ).pop();

                    if (!lastMessageA && !lastMessageB) return 0;
                    if (!lastMessageA) return 1;
                    if (!lastMessageB) return -1;
                    return new Date(lastMessageB.created_at) - new Date(lastMessageA.created_at);
                });
            }

            function populateUserList() {
                let userListContainer = document.getElementById('user-list-container');
                userListContainer.innerHTML = '';

                sortUsersByLastMessage();

                users.forEach(user => {
                    if (user.usertype !== 'dentistrystudent' && user.usertype !== 'patient') {
                        let userMessages = messages.filter(m => 
                            (m.sender_id === user.id && m.recipient_id === currentUserId) || 
                            (m.sender_id === currentUserId && m.recipient_id === user.id)
                        );

                        let userItem = document.createElement('div');
                        userItem.className = 'user-item';
                        userItem.dataset.username = user.name;
                        userItem.dataset.userid = user.id;
                        userItem.innerHTML = `
                            <div>
                                ${user.name}
                                <div class="recent-message" id="recent-${user.name}"></div>
                            </div>
                        `;
                        userItem.addEventListener('click', function() {
                            selectUser(user.name, user.id);
                        });
                        userListContainer.appendChild(userItem);

                        if (userMessages.length > 0) {
                            let lastMessage = userMessages[userMessages.length - 1];
                            updateRecentMessage(user.name, lastMessage);
                        }
                    }
                });
            }


            function updateRecentMessage(username, message) {
                let recentMessageElement = document.getElementById(`recent-${username}`);
                if (recentMessageElement) {
                    let lastMessagePreview = message.message.substring(0, 30) + (message.message.length > 30 ? '...' : '');
                    let lastMessageSender = message.sender_id === currentUserId ? 'You' : username;
                    recentMessageElement.innerHTML = `<span class="last-sender">${lastMessageSender}:</span> ${lastMessagePreview}`;
                }
            }

            populateUserList();

            if (selectedUser) {
                let userItem = document.querySelector(`.user-item[data-username="${selectedUser}"]`);
                if (userItem) {
                    selectUser(userItem.dataset.username, userItem.dataset.userid);
                }
            } else {
                let firstUser = document.querySelector('.user-item');
                if (firstUser) {
                    selectUser(firstUser.dataset.username, firstUser.dataset.userid);
                }
            }

            // Search functionality
            document.getElementById('search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                let searchQuery = document.getElementById('search-input').value.toLowerCase();
                let userItems = document.querySelectorAll('.user-item');
                userItems.forEach(item => {
                    let username = item.dataset.username.toLowerCase();
                    if (username.includes(searchQuery)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Handle form submission
            document.getElementById('chat-form').addEventListener('submit', function(e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);

                // Immediately add the message to the chat
                let newMessage = {
                    sender_id: currentUserId,
                    recipient_id: formData.get('recipient_id'),
                    message: formData.get('message'),
                    created_at: new Date().toISOString()
                };
                addMessageToChat(newMessage);
                updateChatList(newMessage);
                messages.push(newMessage);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Message sent successfully');
                    } else {
                        console.error('Error sending message:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

                form.reset();
            });
        });

        function selectUser(username, userid) {
            localStorage.setItem('selectedUser', username);
            document.querySelectorAll('.user-item').forEach(item => {
                item.classList.remove('selected');
            });
            let selectedUserItem = document.querySelector(`.user-item[data-username="${username}"]`);
            if (selectedUserItem) {
                selectedUserItem.classList.add('selected');
                showChatPanel(username);
                document.getElementById('recipient_id').value = userid;
            }
        }

        function showChatPanel(username) {
            document.querySelectorAll('.chat-messages').forEach(panel => {
                panel.style.display = 'none';
            });

            let chatPanel = document.getElementById(`chat-panel-${username}`);
            if (chatPanel) {
                chatPanel.style.display = 'block';
                chatPanel.scrollTop = chatPanel.scrollHeight;
            } 
        }

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
                chatPanel.scrollTop = chatPanel.scrollHeight;
            }
        }

        function updateChatList(message) {
            let userItem = document.querySelector(`.user-item[data-userid="${message.sender_id === {{ auth()->id() }} ? message.recipient_id : message.sender_id}"]`);
            if (userItem) {
                let recentMessage = userItem.querySelector('.recent-message');
                recentMessage.innerHTML = `<span class="last-sender">You:</span> ${message.message.substring(0, 30)}${message.message.length > 30 ? '...' : ''}`;
                userItem.parentNode.prepend(userItem);
            }
        }
    </script>
</body>
</html>

@section('title')
    Messages
@endsection
</x-app-layout>