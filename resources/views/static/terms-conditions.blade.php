@extends('layouts.layout')

@section('title', 'Terms and Conditions')

@section('content')
    <!--=================================
                    inner banner -->
    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Terms and Conditions</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                        <li><span>Terms and Conditions</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                    inner banner -->

    <!--=================================
                    terms and conditions -->
    <section class="space-ptb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="terms-conditions">
                        <h4 class="mb-4">Terms and Conditions</h4>
                        <p class="mb-4">Last Updated: {{ date('F d, Y') }}</p>

                        <p class="mb-4">These Terms and Conditions govern your use of the Motor Saal website and services.
                            By accessing or using our platform, you agree to be bound by these terms.</p>

                        <h5 class="mb-3 mt-4">1. Acceptance of Terms</h5>
                        <p>By accessing or using Motor Saal, you acknowledge that you have read, understood, and agree to be
                            bound by these Terms and Conditions.</p>

                        <h5 class="mb-3 mt-4">2. Services</h5>
                        <p>Motor Saal provides an online platform for buying, selling, and listing vehicles. We do not buy
                            or sell vehicles directly but facilitate transactions between users.</p>

                        <h5 class="mb-3 mt-4">3. User Accounts</h5>
                        <p>To access certain features, you may need to create an account. You agree to:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">Provide accurate and complete information</li>
                            <li class="mb-2">Maintain and update your information as needed</li>
                            <li class="mb-2">Keep your password confidential</li>
                            <li class="mb-2">Notify us immediately of any unauthorized use of your account</li>
                        </ul>

                        <h5 class="mb-3 mt-4">4. User Content</h5>
                        <p>You are responsible for all content you upload, including vehicle listings, photos, and
                            descriptions. You agree not to:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">Post false, misleading, or fraudulent information</li>
                            <li class="mb-2">Infringe on intellectual property rights</li>
                            <li class="mb-2">Violate any laws or regulations</li>
                            <li class="mb-2">Post content that is offensive or harmful</li>
                        </ul>

                        <h5 class="mb-3 mt-4">5. Prohibited Activities</h5>
                        <p>You agree not to engage in any of the following activities:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">Using the platform for illegal purposes</li>
                            <li class="mb-2">Harassing or threatening other users</li>
                            <li class="mb-2">Attempting to interfere with the platform's functionality</li>
                            <li class="mb-2">Collecting information about other users without their consent</li>
                        </ul>

                        <h5 class="mb-3 mt-4">6. Intellectual Property</h5>
                        <p>All content on Motor Saal, including logos, text, images, and software, is owned by or licensed
                            to us and is protected by intellectual property laws.</p>

                        <h5 class="mb-3 mt-4">7. Disclaimer of Warranties</h5>
                        <p>Motor Saal is provided "as is" without warranties of any kind. We do not guarantee the accuracy,
                            reliability, or availability of the platform.</p>

                        <h5 class="mb-3 mt-4">8. Limitation of Liability</h5>
                        <p>To the fullest extent permitted by law, Motor Saal shall not be liable for any indirect,
                            incidental, or consequential damages arising from your use of the platform.</p>

                        <h5 class="mb-3 mt-4">9. Indemnification</h5>
                        <p>You agree to indemnify and hold harmless Motor Saal and its affiliates from any claims, damages,
                            or expenses arising from your use of the platform or violation of these terms.</p>

                        <h5 class="mb-3 mt-4">10. Termination</h5>
                        <p>We reserve the right to suspend or terminate your account at any time for any reason, including
                            violation of these terms.</p>

                        <h5 class="mb-3 mt-4">11. Changes to Terms</h5>
                        <p>We may modify these terms at any time. Continued use of the platform after changes constitutes
                            acceptance of the revised terms.</p>

                        <h5 class="mb-3 mt-4">12. Governing Law</h5>
                        <p>These terms are governed by the laws of the jurisdiction where Motor Saal operates, without
                            regard to conflict of law principles.</p>

                        <h5 class="mb-3 mt-4">13. Contact Information</h5>
                        <p>If you have any questions about these Terms and Conditions, please contact us at:</p>
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
                    terms and conditions -->
@endsection
