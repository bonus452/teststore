@extends('layouts.app')

@section('title', 'Checkout')

@section('h1', 'Checkout')

@section('content')
<section class="our-checkout-area ptb--120 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <div class="ckeckout-left-sidebar">
                    <!-- Start Checkbox Area -->
                    <div class="checkout-form">
                        <h2 class="section-title-3">Billing details</h2>
                        <div class="checkout-form-inner">
                            <div class="single-checkout-box">
                                <input type="text" placeholder="First Name*">
                                <input type="text" placeholder="Last Name*">
                            </div>
                            <div class="single-checkout-box">
                                <input type="email" placeholder="Emil*">
                                <input type="text" placeholder="Phone*">
                            </div>
                            <div class="single-checkout-box">
                                <textarea name="message" placeholder="Message*"></textarea>
                            </div>

                            <div class="single-checkout-box">
                                <input type="email" placeholder="Address*">
                                <input type="text" placeholder="Zip Code*">
                            </div>
                        </div>
                    </div>
                    <!-- End Checkbox Area -->
                    <!-- Start Payment Box -->
                    <div class="payment-form">
                        <h2 class="section-title-3">payment details</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur kgjhyt</p>
                    </div>
                    <!-- End Payment Box -->
                    <!-- Start Payment Way -->
                    <div class="our-payment-sestem">
                        <ul class="payment-menu">
                            <li><a href="#"><img src="images/payment/1.jpg" alt="payment-img"></a></li>
                            <li><a href="#"><img src="images/payment/2.jpg" alt="payment-img"></a></li>
                            <li><a href="#"><img src="images/payment/3.jpg" alt="payment-img"></a></li>
                            <li><a href="#"><img src="images/payment/4.jpg" alt="payment-img"></a></li>
                            <li><a href="#"><img src="images/payment/5.jpg" alt="payment-img"></a></li>
                        </ul>
                    </div>
                    <!-- End Payment Way -->

                    <div class="payment-form">
                        <h2 class="section-title-3">delivery details</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur kgjhyt</p>
                    </div>
                    <!-- End Payment Box -->
                    <!-- Start Payment Way -->
                    <div class="our-payment-sestem">
                        <ul class="payment-menu">
                            <li><a href="#"><img src="images/payment/1.jpg" alt="payment-img"></a></li>
                            <li><a href="#"><img src="images/payment/2.jpg" alt="payment-img"></a></li>
                            <li><a href="#"><img src="images/payment/3.jpg" alt="payment-img"></a></li>
                            <li><a href="#"><img src="images/payment/4.jpg" alt="payment-img"></a></li>
                            <li><a href="#"><img src="images/payment/5.jpg" alt="payment-img"></a></li>
                        </ul>
                        <div class="shop__btn">
                            <a class="htc__btn" href="#">CONFIRM</a>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="checkout-right-sidebar">
                    <div class="our-important-note">
                        <h2 class="section-title-3">Note :</h2>
                        <p class="note-desc">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut laborekf et dolore magna aliqua.</p>
                        <ul class="important-note">
                            <li><a href="#"><i class="zmdi zmdi-caret-right-circle"></i>Lorem ipsum dolor sit amet, consectetur nipabali</a></li>
                            <li><a href="#"><i class="zmdi zmdi-caret-right-circle"></i>Lorem ipsum dolor sit amet</a></li>
                            <li><a href="#"><i class="zmdi zmdi-caret-right-circle"></i>Lorem ipsum dolor sit amet, consectetur nipabali</a></li>
                            <li><a href="#"><i class="zmdi zmdi-caret-right-circle"></i>Lorem ipsum dolor sit amet, consectetur nipabali</a></li>
                            <li><a href="#"><i class="zmdi zmdi-caret-right-circle"></i>Lorem ipsum dolor sit amet</a></li>
                        </ul>
                    </div>
                    <div class="puick-contact-area mt--60">
                        <h2 class="section-title-3">Quick Contract</h2>
                        <a href="phone:+8801722889963">+012 345 678 102 </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
