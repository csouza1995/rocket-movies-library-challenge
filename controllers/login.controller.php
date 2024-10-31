<?php

if (auth()) {
    redirect('/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = Validator::validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ], $_POST, [
        'email' => 'E-mail',
        'password' => 'Password',
    ]);

    if (!$validator->isValid()) {
        Session::flash('errors', $validator->getErrors());
        Session::flash('old', $_POST);

        Session::flash('message::error', 'Please check your form for errors');

        redirect('login');
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $database
        ->query(
            'SELECT * FROM users WHERE email = :email',
            compact('email'),
            User::class
        )
        ->fetch();

    if (!password_verify($password, $user->password ?? '')) {
        Session::flash('message::error', 'Invalid credentials');
        redirect('login');
    }

    Session::set('auth', $user);
    redirect('/');
}

view('login', layout: 'auth');
