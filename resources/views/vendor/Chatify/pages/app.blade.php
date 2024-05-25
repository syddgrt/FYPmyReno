@include('Chatify::layouts.headLinks')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>
    <div style="margin-left: 50px; margin-right: 50px;">
        <div class="container mx-auto px-4">
            <div class="messenger" data-id="{{ $id }}">
                {{-- Messenger content --}}
                <div class="messenger-listView">
                    {{-- Users/Groups list side --}}
                    <div class="m-header">
                        <nav>
                            <i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span>
                        </nav>
                        <input type="text" class="messenger-search" placeholder="Search" />
                    </div>
                    <div class="m-body contacts-container">
                        <div class="show messenger-tab users-tab app-scroll" data-view="users">
                            <div class="favorites-section">
                                <p class="messenger-title"><span>Favorites</span></p>
                                <div class="messenger-favorites app-scroll-hidden"></div>
                            </div>
                            <p class="messenger-title"><span>Your Space</span></p>
                            {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
                            <p class="messenger-title"><span>All Messages</span></p>
                            <div class="listOfContacts" style="width: 100%; height: calc(100% - 272px); position: relative;"></div>
                        </div>
                        <div class="messenger-tab search-tab app-scroll" data-view="search">
                            <p class="messenger-title"><span>Search</span></p>
                            <div class="search-records">
                                <p class="message-hint center-el"><span>Type to search..</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Messaging side --}}
                <div class="messenger-messagingView">
                    <div class="m-header m-header-messaging">
                        <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                            <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                                <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                                <div class="avatar av-s header-avatar" style="margin: 0px 10px;"></div>
                                <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                            </div>
                            <nav class="m-header-right">
                                <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                                <a href="/dashboard"><i class="fas fa-home"></i></a>
                                <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                            </nav>
                        </nav>
                        <div class="internet-connection">
                            <span class="ic-connected">Connected</span>
                            <span class="ic-connecting">Connecting...</span>
                            <span class="ic-noInternet">No internet access</span>
                        </div>
                    </div>

                    <div class="m-body messages-container app-scroll">
                        <div class="messages">
                            <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
                        </div>
                        <div class="typing-indicator">
                            <div class="message-card typing">
                                <div class="message">
                                    <span class="typing-dots">
                                        <span class="dot dot-1"></span>
                                        <span class="dot dot-2"></span>
                                        <span class="dot dot-3"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('Chatify::layouts.sendForm')
                </div>

                {{-- Info side --}}
                <div class="messenger-infoView app-scroll">
                    <nav>
                        <p>User Details</p>
                        <a href="#"><i class="fas fa-times"></i></a>
                    </nav>
                    {!! view('Chatify::layouts.info')->render() !!}
                </div>
            </div>
        </div>
    </div>
    @include('Chatify::layouts.modals')
    @include('Chatify::layouts.footerLinks')
</x-app-layout>
