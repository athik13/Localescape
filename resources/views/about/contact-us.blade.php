@extends('layouts.app')

@section('content')
    
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Contact Us</li>
            </ol>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar">
                        <div class="box filter">
                            <h2>About Us</h2>
                            <ul class="links">
                                <li><a href="{{ url('/about-us') }}">About Us</a></li>
                                <li><a href="{{ url('/become-an-affiliate') }}">Become an Affiliate</a></li>
                                <li><a href="{{ url('/terms-and-conditions') }}">Terms & Conditions</a></li>
                                <li class="active"><a href="{{ url('/contact-us') }}">Contact Us</a></li>
                            </ul>
                        </div>
                        <!--end filter-->
                    </div>
                    <!--end sidebar-->
                </div>
                <!--end col-md-3-->
                <div class="col-md-9">
                    <div class="main-content">
                        <div class="title">
                            <h1>Contact Us</h1>
                        </div>
                        <!--end title-->
                        <section>
                            <div class="row">
                                <div class="col-md-4">
                                    <h2>Address</h2>
                                    <address>
                                        <strong>Local Escape Maldives</strong>
                                        <br>
                                        G.Villa Shabnamee,
                                        <br>
                                        Handhuvarudhey Goalhi, Malé 20101
                                        <br>
                                        Phone: 4008800
                                        <br>                                        
                                        Fax: 4008811
                                        <br>
                                        <a href="#">info@localescapemaldives.com</a><br>

                                    </address>
                                    <h2>Social Profiles</h2>
                                    <div class="social-icons">
                                        <a href="https://www.facebook.com/localescapemaldives/"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-instagram"></i></a>
                                        <a href="#"><i class="fa fa-youtube"></i></a>
                                    </div>
                                </div>
                                <!--end col-md-8-->
                                <div class="col-md-8">
                                    <h2>Map</h2>
                                    <div id="map-item" class="map"></div>
                                    <!--end contact-map-->
                                </div>
                                <!--end col-md-8-->
                            </div>
                            <!--end row-->
                        </section>
                        <section>
                            <form class="labels-uppercase clearfix">
                                <h2>Contact Form</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form-contact-name">Your Name<em>*</em></label>
                                            <input type="text" class="form-control" id="form-contact-name" name="location" placeholder="Name" required="">
                                        </div>
                                    </div>
                                    <!--end col-md-6-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form-contact-email">Your Email<em>*</em></label>
                                            <input type="email" class="form-control" id="form-contact-email" name="location" placeholder="Email" required="">
                                        </div>
                                    </div>
                                    <!--end col-md-6-->
                                </div>
                                <!--end row-->
                                <div class="form-group">
                                    <label for="form-contact-message">Your Message<em>*</em></label>
                                    <textarea class="form-control" id="form-contact-message" rows="8" name="form-contact-message" required="" placeholder="Message"></textarea>
                                </div>
                                <!--end form-group-->
                                <div id="form-status" class="pull-left"></div>
                                <div class="form-group pull-right">
                                    <button type="submit" class="btn btn-primary btn-rounded">Send Message</button>
                                </div>
                                <!--end form-group-->
                            </form>
                            <!--end form-->
                        </section>
                    </div>
                    <!--end main-content-->
                </div>
                <!--end col-md-9-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->

@endsection