@extends('layouts.app') 
@section('content')
<!-- Team page -->
<!-- INTRO -->
<section class="white-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FEATURED ARTIST -->
<div id="all_teams">
    

</div>
{{-- @include('include.team.our_team') --}}


<script>
$(document).ready(function(){
    $.get("all_teams",function(data){
        $("#all_teams").html(data);
    }); 

});
</script>
@endsection