@extends('layouts.layout')

@section('title', 'Privacy Policy')

@section('content')
    <!--=================================
                                inner banner -->
    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Privacy Policy</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Home</a> <i
                                class="fa fa-angle-double-right"></i></li>
                        <li><span>Privacy Policy</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                                inner banner -->

    <!--=================================
                                privacy policy -->
    <section class="space-ptb mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="privacy-policy">
                        <h4 class="mb-4">Privacy Policy</h4>
                        <p class="mb-4">Last Updated: {{ date('F d, Y') }}</p>

                        <p class="mb-4">This Privacy Policy describes how Motor Saal ("we," "us," or "our") collects,
                            uses, and shares your personal information when you visit our website or use our services.</p>

                        <h5 class="mb-3 mt-4">Information We Collect</h5>
                        <p>We may collect the following types of information:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Personal Information:</strong> Name, email address, phone number,
                                mailing address, and other contact details.</li>
                            <li class="mb-2"><strong>Vehicle Information:</strong> Details about vehicles you list, search
                                for, or express interest in.</li>
                            <li class="mb-2"><strong>Account Information:</strong> Username, password, and profile
                                preferences.</li>
                            <li class="mb-2"><strong>Usage Data:</strong> Information about how you interact with our
                                website and services.</li>
                        </ul>

                        <h5 class="mb-3 mt-4">How We Use Your Information</h5>
                        <p>We use your information for various purposes:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">To provide and maintain our services</li>
                            <li class="mb-2">To communicate with you, including responding to inquiries</li>
                            <li class="mb-2">To personalize your experience on our platform</li>
                            <li class="mb-2">To improve our website and services</li>
                            <li class="mb-2">To comply with legal obligations</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Information Sharing</h5>
                        <p>We do not sell or rent your personal information to third parties. We may share your information
                            with:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Service Providers:</strong> Third-party vendors who assist us in
                                operating our website and providing services.</li>
                            <li class="mb-2"><strong>Legal Compliance:</strong> When required by law or to protect our
                                rights and property.</li>
                            <li class="mb-2"><strong>Business Transfers:</strong> In connection with a merger,
                                acquisition, or sale of assets.</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Data Security</h5>
                        <p>We implement appropriate security measures to protect your personal information. However, no
                            method of transmission over the Internet is 100% secure.</p>

                        <h5 class="mb-3 mt-4">Your Rights</h5>
                        <p>You have the right to:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">Access and update your personal information</li>
                            <li class="mb-2">Request deletion of your personal information</li>
                            <li class="mb-2">Object to or restrict processing of your information</li>
                            <li class="mb-2">Withdraw consent for data processing</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Cookies</h5>
                        <p>We use cookies and similar tracking technologies to enhance your browsing experience. You can
                            control cookie settings through your browser.</p>

                        <h5 class="mb-3 mt-4">Changes to This Policy</h5>
                        <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting
                            the new policy on this page.</p>

                        <h5 class="mb-3 mt-4">Contact Us</h5>
                        <p>If you have any questions about this Privacy Policy, please contact us at:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Email:</strong> support@motarsal.com</li>
                            <li class="mb-2"><strong>Phone:</strong> 077 9600 2750 / 072 806 3532</li>
                            <li class="mb-2"><strong>Address:</strong> 220E Front St. Burlington NC 27215</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=================================
                                privacy policy -->
@endsection
