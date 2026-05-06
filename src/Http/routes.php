<?php

$chatRoutesPrefix = config('musonza_chat.routes.path_prefix');
$middleware = config('musonza_chat.routes.middleware');

Route::group([
    'middleware' => $middleware,
    'namespace' => 'Musonza\Chat\Http\Controllers\Api',
    'prefix' => $chatRoutesPrefix,
], function () {
    // Conversations
    Route::get('/conversations', 'ConversationApiController@index');
    Route::post('/conversations', 'ConversationApiController@store');
    Route::get('/conversations/{conversation}/messages', 'ConversationApiController@messages');
    Route::post('/conversations/{conversation}/messages', 'ConversationApiController@storeMessage');
    Route::post('/conversations/{conversation}/read', 'ConversationApiController@read');
    Route::post('/conversations/{conversation}/pin', 'ConversationApiController@pin');
    Route::post('/conversations/{conversation}/favorite', 'ConversationApiController@favorite');
    Route::post('/conversations/{conversation}/archive', 'ConversationApiController@archive');
    Route::post('/conversations/{conversation}/participants', 'ConversationApiController@storeParticipant');
    Route::delete('/conversations/{conversation}/participants/{user}', 'ConversationApiController@destroyParticipant');

    // Messages
    Route::put('/messages/{message}', 'MessageApiController@update');
    Route::delete('/messages/{message}', 'MessageApiController@destroy');
    Route::post('/messages/{message}/reactions', 'MessageApiController@storeReaction');
    Route::delete('/messages/{message}/reactions/{emoji}', 'MessageApiController@destroyReaction');
    Route::post('/messages/{message}/pin', 'MessageApiController@pin');

    // Channels
    Route::get('/channels', 'ChannelApiController@index');
    Route::post('/channels', 'ChannelApiController@store');
    Route::delete('/channels/{channel}/members/me', 'ChannelApiController@destroyMemberMe');
    Route::post('/channels/{channel}/members', 'ChannelApiController@storeMember');
    Route::delete('/channels/{channel}/members/{user}', 'ChannelApiController@destroyMember');
    Route::post('/channels/{channel}/favorite', 'ChannelApiController@favorite');

    // Users
    Route::get('/users', 'UserApiController@index');
});
