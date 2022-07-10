<?php

//Admin-panel

//Admin
Breadcrumbs::for('admin.index', function ($trail) {
    $trail->push('Admin', route('admin.index'));
});
//Admin->Category
Breadcrumbs::for('admin.catalog.index', function ($trail) {
    $trail->parent('admin.index');
    $trail->push('Catalog', route('admin.catalog.index'));
});



//Public
//Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

//Home->Login
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('home');
    $trail->push('Login & Register', route('login'));
});

//Home->Login
Breadcrumbs::for('personal.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Personal', route('personal.index'));
});



//Catalog
Breadcrumbs::for('catalog.index', function ($trail) {
    $trail->parent('home');
    $trail->push('catalog', route('catalog.index'));
});

