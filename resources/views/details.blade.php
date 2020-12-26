@extends('layouts.app')

@section('content')
@include('include.menu')
<div class="gap-30"></div>


<!-- ad banner start-->
<div class="block-wrapper no-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="banner-img">
                    <a href="index.html">
                        <img class="img-fluid" src="front/images/banner-image/image4.png" alt="">
                    </a>
                </div>
            </div>
            <!-- col end -->
        </div>
        <!-- row  end -->
    </div>
    <!-- container end -->
</div>
<!-- ad banner end-->
<div class="gap-50"></div>

<!-- ad banner start-->
<div class="newsletter-area">
    <div class="container">
        <div class="row ts-gutter-30 justify-content-center align-items-center">
            <div class="col-lg-7 col-md-6">
                <div class="footer-loto">
                    <a href="#">
                        <img src="front/images/logos/logo-light.png" alt="">
                    </a>
                </div>
            </div>
            <!-- col end -->
            <div class="col-lg-5 col-md-6">
                <div class="footer-newsletter">
                    <form action="#" method="post">
                        <div class="email-form-group">
                            <i class="news-icon fa fa-paper-plane" aria-hidden="true"></i>
                            <input type="email" name="EMAIL" class="newsletter-email" placeholder="Your email"
                                required>
                            <input type="submit" class="newsletter-submit" value="Subscribe">
                        </div>

                    </form>
                </div>
            </div>
            <!-- col end -->
        </div>
        <!-- row  end -->
    </div>
    <!-- container end -->
</div>
<!-- ad banner end-->
@endsection