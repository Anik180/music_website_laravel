@extends('layouts.app')
@section('css')
<style type="text/css">
    .main-container {
        background: #fff !important;
    }
    .section{
        margin-top: 3rem;
    }
    .containers{
        margin-top: 15rem;
    }
    .submit_btn{
        font-size: 15px;
        padding: 12px 24px;
        border-radius: 3px; 
        background: #5cb85c;
        color: #fff;
        box-sizing: border-box;
        box-shadow: 5px 5px rgba(0, 0, 0, 1);
    }
    .submit_btn:hover{
        /*box-sizing: border-box;*/
        box-shadow: 0px 0px rgba(0, 0, 0, 1);
        color: #fff;
    }
    h2{
        font-size: 25px;
    }
    .row{
       text-align: center; 
       padding-bottom: 200px; 
    }
    @media only screen and (max-width: 700px) {
      .col-md-6{
        margin-top: 30px;
      }
      .containers{
        margin-top: 5rem;
      }
      .row{
        padding-bottom: 20px; 
      }
    }

</style>

@endsection
@section('content')

<section class="section featured-shop">
        <div class="containers">
            <div class="row">
               <div class="col-md-6">
                   <h2>{{$submit_music->title_1}}</h2>
                   <div style="margin-top: 15px;">
                       <a href="{{$submit_music->url_1}}" class="submit_btn" target="_blank">Click Here</a>
                   </div>
               </div>
               <div class="col-md-6">
                   <h2>{{$submit_music->title_2}}</h2>
                   <div style="margin-top: 15px;">
                       <a href="{{$submit_music->url_2}}" class="submit_btn" target="_blank">Click Here</a>
                   </div>
               </div>
            </div>
            
        </div>
    </section>
@endsection