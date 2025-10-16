@extends('layouts.layout')

@section('title', 'Contact Us')

@section('content')
    <!--=================================
                                        inner banner -->
    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Get In Touch</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Home</a> <i
                                class="fa fa-angle-double-right"></i></li>
                        <li><span>Get In Touch</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                                        inner banner -->

    <!--=================================
                                        contact us -->
    <section class="space-ptb mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="contact-info">
                        <h4 class="mb-4">Get In Touch</h4>
                        <p class="mb-4">Have questions or feedback? We'd love to hear from you. Reach out to us using the
                            contact information below or send us a message.</p>

                        <div class="contact-address">
                            <ul class="list-unstyled">
                                <li class="mb-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fa fa-map-marker fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Our Address</h6>
                                            <p class="mb-0">Kart-e-Mamorin, Khushal khan Mena, Kabul, Afghanistan</p>
                                        </div>
                                    </div>
                                </li>

                                <li class="mb-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fa fa-phone fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Phone Number</h6>
                                            <p class="mb-0">0 780 480 980 / 072 806 3532</p>
                                        </div>
                                    </div>
                                </li>

                                <li class="mb-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fa fa-envelope fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Email Address</h6>
                                            <p class="mb-0">info@topmotar.com</p>
                                        </div>
                                    </div>
                                </li>

                                <li class="mb-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fa fa-clock fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Working Hours</h6>
                                            <p class="mb-0">7/24</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="social-icons mt-5">
                            <h6 class="mb-3">Follow Us</h6>
                            <ul class="list-inline">
                                <li class="list-inline-item me-3">
                                    <a href="#" class="btn btn-outline-primary rounded-circle">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item me-3">
                                    <a href="#" class="btn btn-outline-info rounded-circle">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item me-3">
                                    <a href="#" class="btn btn-outline-danger rounded-circle">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="btn btn-outline-danger rounded-circle">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact-form">
                        <h4 class="mb-4">Send Us a Message</h4>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Your Email" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" placeholder="Your Message" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.092940420443!2d-122.419415484682!3d37.77492927975934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c00000001%3A0x0!2zNDDCsDQ2JzI5LjciTiAxMDDCsDI1JzAwLjAiVw!5e0!3m2!1sen!2sus!4v1617890000000!5m2!1sen!2sus"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=================================
                                        contact us -->
@endsection
