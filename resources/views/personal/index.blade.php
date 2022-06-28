@extends('layouts.app')

@section('h1', 'Personal')

@section('content')
<section class="blog-details-wrap ptb--120 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                <div class="blod-details-right-sidebar">
                    <!-- Start Category Area -->
                    <div class="our-category-area mt--60">
                        <h2 class="section-title-2">{{ Auth::user()->name }}</h2>
                        <ul class="categore-menu">
                            <li><a href="#"></i>Settings</a></li>
                            <li><a href="#"></i>Orders</a></li>
                            <li><a href="#"></i>Wishlist</a></li>
                            <li><a href="#"></i>Cart</a></li>
                            <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"></i>Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                <div class="blog-details-left-sidebar mrg-blog">
                    <div class="blog-details-top">

                        <div class="our-reply-form-area mt--20">
                            <h2 class="section-title-2">LEAVE A REPLY</h2>
                            <div class="reply-form-inner mt--40">
                                <div class="reply-form-box">
                                    <div class="reply-form-box-inner">
                                        <div class="rfb-single-input">
                                            <input type="text" placeholder="Name*">
                                        </div>
                                        <div class="rfb-single-input">
                                            <input type="email" placeholder="Email*">
                                        </div>
                                    </div>
                                </div>
                                <div class="reply-form-box">
                                    <textarea name="message" placeholder="Message"></textarea>
                                </div>
                                <div class="blog__details__btn">
                                    <a class="htc__btn btn--gray" href="#">submit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
