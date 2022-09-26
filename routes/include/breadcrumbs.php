<?php

//Admin-panel

//Admin
Breadcrumbs::for('admin.index', function ($trail) {
    $trail->push('Admin', route('admin.index'));
});
//Admin->Catalog
Breadcrumbs::for('admin.catalog.index', function ($trail) {
    $trail->parent('admin.index');
    $trail->push('Catalog', route('admin.catalog.index'));
});
//Admin->Category->create
Breadcrumbs::for('admin.catalog.category.create_form', function ($trail) {
    $trail->parent('admin.catalog.index');
    $trail->push('New Category', route('admin.catalog.category.create_form'));
});
//Admin->Product->create
Breadcrumbs::for('admin.catalog.product.create_form', function ($trail) {
    $trail->parent('admin.catalog.index');
    $trail->push('New Product', route('admin.catalog.product.create_form'));
});

//Admin->Delivery
Breadcrumbs::for('admin.sale.delivery.list', function ($trail) {
    $trail->parent('admin.index');
    $trail->push('Delivery', route('admin.sale.delivery.list'));
});

//Admin->Delivery->Create
Breadcrumbs::for('admin.sale.delivery.create_form', function ($trail) {
    $trail->parent('admin.sale.delivery.list');
    $trail->push('Create delivery', route('admin.sale.delivery.create_form'));
});

//Admin->Delivery->Update
Breadcrumbs::for('admin.sale.delivery.update_form', function ($trail, $delivery) {
    $trail->parent('admin.sale.delivery.list');
    $trail->push("Update delivery " . $delivery->name, route('admin.sale.delivery.update_form', $delivery));
});

//Admin->Payment
Breadcrumbs::for('admin.sale.payment.list', function ($trail) {
    $trail->parent('admin.index');
    $trail->push('Payment', route('admin.sale.payment.list'));
});

//Admin->Payment->Create
Breadcrumbs::for('admin.sale.payment.create_form', function ($trail) {
    $trail->parent('admin.sale.payment.list');
    $trail->push('Create payment', route('admin.sale.payment.create_form'));
});

//Admin->Payment->Update
Breadcrumbs::for('admin.sale.payment.update_form', function ($trail, $payment) {
    $trail->parent('admin.sale.payment.list');
    $trail->push("Update payment " . $payment->name, route('admin.sale.payment.update_form', $payment));
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


//sale
Breadcrumbs::for('sale.cart.list', function ($trail) {
    $trail->parent('home');
    $trail->push('Cart', route('sale.cart.list'));
});

Breadcrumbs::for('sale.order.show', function ($trail) {
    $trail->parent('home');
    $trail->push('Checkout', route('sale.order.show'));
});

