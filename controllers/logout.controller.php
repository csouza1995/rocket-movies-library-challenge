<?php

if (auth()) {
    Session::destroy();
}

redirect('login');
