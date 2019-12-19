<?php

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('typingevent', function($user) {
    return Auth()->check();
});

Broadcast::channel('liveuser', function($user) {
    return $user;
});