<?php

if (auth()) {
    redirect('/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = Validator::validate([
        'name' => ['required', 'max:255'],
        'surname' => ['required', 'max:255'],
        'register_email' => ['required', 'email', 'unique:users,email', 'max:255', 'confirmed:register_email_confirm'],
        'register_password' => ['required', 'min:6', 'max:255', 'strong'],
    ], $_POST, [
        'name' => 'Name',
        'surname' => 'Surname',
        'register_email' => 'Email',
        'register_password' => 'Password',
    ]);

    if (!$validator->isValid()) {
        Session::flash('errors', $validator->getErrors());
        Session::flash('old', $_POST);

        Session::flash('message::error', 'Please check your form for errors');

        redirect('login?type=register');
    }

    $database->query(
        'INSERT INTO users (name, surname, email, password) values (:name, :surname, :email, :password)',
        [
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'email' => $_POST['register_email'],
            'password' => password_hash($_POST['register_password'], PASSWORD_DEFAULT),
        ]
    );

    Session::flash('message::success', 'You have successfully registered!');
}

redirect('login');
