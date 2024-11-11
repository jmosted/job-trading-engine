<?php

$router->get('/',function(){ return "Job trading engine"; });

$router->post('api/register', 'AuthController@register');

$router->group(['middleware'=>'cors1'], function() use($router){
    $router->post('/api/login','AuthController@login');
});

$router->get('/api/documentation', '\SwaggerLume\Http\Controllers\SwaggerLumeController@api');
$router->get('/docs', '\SwaggerLume\Http\Controllers\SwaggerLumeController@docs');

$router->group(['middleware'=>'api'], function () use ($router) {
    // Matches "/api/register
    ///$router->post('login', 'AuthController@login');
    // $router->group(['middleware'=> 'role'], function() use($router){
    //     $router->post("/api/category",   "CategoryController@save");
    //     $router->delete("/api/category",   "CategoryController@remove");
    // });

    $router->post("/api/category",   "CategoryController@save");
    $router->delete("/api/category",   "CategoryController@remove");
    $router->get("/api/category",   "CategoryController@index");
    
    $router->get("/api/users", "UserController@index");
    $router->get("/api/users/getInfo/{id}", "UserController@user");
    $router->post("/api/users", "UserController@save");
    $router->delete("/api/users/{id}", "UserController@remove");
    $router->get('/api/users/getByToken', 'UserController@getByToken');

    $router->get("/api/offers", "OfferController@index");
    $router->get("/api/offer/getInfo/{id}", "OfferController@offer");
    $router->post("/api/offer", "OfferController@save");
    $router->delete("/api/offer/{id}", "OfferController@remove");
    $router->get("/api/offer/getByUserId/{user}", "OfferController@getByUser");
    $router->get("/api/offer/getByCategoryId/{category}", "OfferController@getByCategory");

    $router->get("/api/offer/image/{offer}", "OfferController@getImageByOfferId");
    
    $router->get("/api/offer/request", "OfferTransactionController@listRequestOffer");  //ok
    $router->get("/api/offer/assign", "OfferTransactionController@listAssignOffer"); //ok

    $router->post("/api/offer/request", "OfferTransactionController@requestOffer");  //ok
    $router->post("/api/offer/assign", "OfferTransactionController@assignOffer"); //ok

    $router->delete("/api/offer/request/{id}", "OfferTransactionController@deleteRequestOffer");
    $router->delete("/api/offer/assign/{id}", "OfferTransactionController@deleteAssignOffer");
    $router->post("/api/offer/reject", "OfferTransactionController@rejectRequestOffer");//ok
    $router->post("/api/offer/reject-assign", "OfferTransactionController@rejectAssignOffer");//ok

    $router->post("/api/offer/finalize", "OfferTransactionController@finalizeOffer");
    $router->post("/api/offer/qualify", "OfferTransactionController@qualifyOffer");
});


