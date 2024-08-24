@extends('layouts.main')

@section('title', 'Contact Us')
@section('breadcrumb-item', 'Ui kit')

@section('breadcrumb-item-active', 'Contact Us')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3718.9624616075307!2d72.86314569999999!3d21.2333371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f3b471f4ce1%3A0x22ace90053cf335!2sCodedThemes!5e0!3m2!1sen!2sin!4v1689227733984!5m2!1sen!2sin"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        class="contact-map"></iframe>
                    <div class="row justify-content-center">
                        <div class="col-11 col-sm-9 col-xl-8">
                            <div class="card contact-card-form user-card">
                                <div class="card-body">
                                    <div class="d-flex mb-4">
                                        <div class="flex-grow-1 me-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avtar bg-brand-color-1 text-white me-3">
                                                    <i class="ph-duotone ph-chats-teardrop f-26"></i>
                                                </div>
                                                <div>
                                                    <h4 class="f-w-500 mb-1">Contact Us</h4>
                                                    <p class="mb-0">Let's Start a Conversation</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" placeholder="Enter name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Subject</label>
                                                <input type="text" class="form-control" placeholder="Enter Subject">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email address</label>
                                                <input type="email" class="form-control" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Contact No.</label>
                                                <input type="text" class="form-control" placeholder="Enter Contact No">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Message</label>
                                                <textarea class="form-control" rows="3" placeholder="Message"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid mt-4">
                                        <button type="button" class="btn btn-primary mx-sm-3 mx-md-5">Send Message</button>
                                    </div>
                                    <div class="saprator my-3">
                                        <span>Or continue with</span>
                                    </div>
                                    <div class="text-center">
                                        <ul class="list-inline mx-auto mt-3 mb-0">
                                            <li class="list-inline-item">
                                                <a href="https://www.facebook.com/"
                                                    class="avtar avtar-s rounded-circle bg-facebook" target="_blank">
                                                    <i class="fab fa-facebook-f text-white"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="https://twitter.com/"
                                                    class="avtar avtar-s rounded-circle bg-twitter" target="_blank">
                                                    <i class="fab fa-twitter text-white"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="https://myaccount.google.com/"
                                                    class="avtar avtar-s rounded-circle bg-googleplus" target="_blank">
                                                    <i class="fab fa-google text-white"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
@endsection
