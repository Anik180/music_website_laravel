@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    .footer-icon {
    display: block;
    float: left;
    padding-top: 5px;
}
span.footer-desc {
    display: flex;
}
</style>
<!-- CONTACTS -->
<section class="section inverse-color contact" id="anchor08">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="voffset120"></div>
                <br>
                <div class="separator-icon">
                    <i class="fa fa fa-microphone"></i>
                </div>
                <div class="voffset30"></div>
                <h4 style="text-align:center; color:white;">Thanks for your interest in Epic Music LA. We want to hear from you! Call, email, or leave a note below.</h4>
                <div class="voffset100"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div role="form" class="wpcf7" id="wpcf7-f283-o1" lang="en-US" dir="ltr">
                    <div class="screen-reader-response"></div>
                    <form action="{{url('contact-us')}}" method="post" class="wpcf7-form contact-form" novalidate="novalidate" id="contactform">
                        @csrf
                        <!-- <div style="display: none;">
                            <input type="hidden" name="_wpcf7" value="283">
                            <input type="hidden" name="_wpcf7_version" value="5.1.4">
                            <input type="hidden" name="_wpcf7_locale" value="en_US">
                            <input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f283-o1">
                            <input type="hidden" name="_wpcf7_container_post" value="0">
                            <input type="hidden" name="_wpcf7cf_hidden_group_fields" value="[]">
                            <input type="hidden" name="_wpcf7cf_hidden_groups" value="[]">
                            <input type="hidden" name="_wpcf7cf_visible_groups" value="[]">
                            <input type="hidden" name="_wpcf7cf_options" value="{&quot;form_id&quot;:283,&quot;conditions&quot;:[],&quot;settings&quot;:{&quot;animation&quot;:&quot;yes&quot;,&quot;animation_intime&quot;:200,&quot;animation_outtime&quot;:200,&quot;notice_dismissed&quot;:false}}">
                        </div> -->
                        <fieldset>
                            <!-- <div class="wpcf7-response-output wpcf7-display-none"></div> -->
                            <div class="form-group">
                                <p>
                                    <label class="title small" for="selectbasic">I am a</label>
                                    <br>
                                    <span class="wpcf7-form-control-wrap selectbasic">
                                        <select name="user_type" class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required form-control" id="selectbasic" aria-required="true" aria-invalid="false">
                                            <option value="">---</option>
                                            <option value="Musician / Composer / Artist">Musician / Composer / Artist</option>
                                            <option value="Branding Manager">Branding Manager</option>
                                            <option value="Creative Supervisor">Creative Supervisor</option>
                                            <option value="Editor">Editor</option>
                                            <option value="Film Director">Film Director</option>
                                            <option value="Music Supervisor">Music Supervisor</option>
                                            <option value="Producer">Producer</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </span>
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="title small" for="name">Name</label>
                                <br>
                                <span class="wpcf7-form-control-wrap name1">
                                    <input type="text" name="first_name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" id="name" aria-required="true" aria-invalid="false" placeholder="First Name">
                                </span>
                                <br>
                                <span class="wpcf7-form-control-wrap name2">
                                    <input type="text" name="last_name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" id="name2" aria-required="true" aria-invalid="false" placeholder="Last Name">
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="title small" for="phone">Phone Number</label>
                                <br>
                                <span class="wpcf7-form-control-wrap phone">
                                    <input type="tel" name="phone" value="" id="phone" class="wpcf7-form-control wpcf7mf-mask wpcf7-mask wpcf7-validates-as-required text email required" size="40" aria-required="1" placeholder="(___)___-____" data-mask="(___)___-____">
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="title small" for="email">Email</label>
                                <br>
                                <span class="wpcf7-form-control-wrap email">
                                    <input type="email" name="email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email email" id="email" aria-required="true" aria-invalid="false" placeholder="Email">
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="title small" for="company">Company</label>
                                <br>
                                <span class="wpcf7-form-control-wrap company">
                                    <input type="text" name="company" value="" size="40" class="wpcf7-form-control wpcf7-text text email required" id="company" aria-invalid="false" placeholder="Company Name">
                                </span>
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label class="title small" for="company">Company Type</label>
                                <br>
                                <span class="wpcf7-form-control-wrap company_type">
                                    <input type="text" name="company_type" value="" size="40" class="wpcf7-form-control wpcf7-text text email required" id="company_type" aria-invalid="false" placeholder="Company Type">
                                </span>
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label class="title small" for="message">Message</label>
                                <br>
                                <span class="wpcf7-form-control-wrap msg">
                                    <textarea name="message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required text area required" id="msg" aria-required="true" aria-invalid="false" placeholder="How May Our EPIC Team Be of Service?"></textarea>
                                </span>
                            </div>
                                <div class="form-group">
                                <label class="title small" for="email">@php echo($first=rand(0,9)) @endphp + @php echo($second=rand(0,9)) @endphp</label>
                                <br>
                                <span class="wpcf7-form-control-wrap email">
                                    <input type="text"  value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email email" id="text" aria-required="true" aria-invalid="false">
                                </span>
                            </div>
                            <p>
                                <br>
                                <input type="submit" id="submit" value="Submit" class="wpcf7-form-control wpcf7-submit btn rounded">
                                <span class="ajax-loader"></span></p>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="col-contact">
                    <div class="sidebars">
                        <div class="sidebars-wrap">
                            <div class="sidebar">
                                <div class="widget_text widget">
                                    <h4 class="widget-title" style="color: #519a0a">Los Angeles Headquarters</h4>
                                    <div class="textwidget custom-html-widget">
                                        <div class="voffset20"></div>
                                        <!--<p><i class="fa fa-map-marker footer-icon contact"></i><span class="footer-desc">{!! $contact_us_address->value !!}</span></p>-->
                                        <ul class="contact">
                                            <li><i class="fa fa-map-marker footer-icon" aria-hidden="true"></i> <span class="footer-desc">{!! $contact_us_address->value !!}</span></li>
                                            <br>
                                            <li><i class="fa fa-phone footer-icon" aria-hidden="true"></i> <span class="footer-desc">{{ $contact_us_phone->value }}</span></li>
                                            <br>
                                            <li><i class="fa fa-envelope  footer-icon" aria-hidden="true"></i>  <span class="footer-desc"><a href="mailto:{{ $contact_us_email->value }}?Subject=From%20website" target="_top">{{ $contact_us_email->value }}</a></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget_text widget">
                                    <h4 class="widget-title">Find Us</h4>
                                    <div class="textwidget custom-html-widget">
                                        <br>
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3305.6982395924356!2d-118.44506368516484!3d34.05161098060602!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2bb79013ff293%3A0xb4bb5c540448372c!2s1527+Veteran+Ave+%236%2C+Los+Angeles%2C+CA+90024%2C+USA!5e0!3m2!1sen!2sbd!4v1496042069615" width="100%" height="370" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                                    </div>
                                </div>
                            </div>
                            <!-- /.sidebar -->
                        </div>
                        <!-- /.sidebars-wrap -->
                    </div>
                    <!-- /.sidebars -->
                    <br>
                </div>
            </div>
        </div>
        <div class="voffset120"></div>
    </div>
</section>

 <script type="text/javascript">
     $(document).ready(function(){
        $('input[id="submit"]').attr('disabled',true);
        $('input[id="text"]').on('keyup',function(){
            if($(this).val()==<?php echo $first+$second ?>){

                $('input[id="submit"]').attr('disabled',false);
                document.getElementById("submit").style.color="white";
                document.getElementById("submit").value="Submit";
            }else
            {
                $('input[id="submit"]').attr('disabled',true);
              
            }
        });

     })
 </script>
@endsection