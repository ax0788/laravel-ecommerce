@extends('frontend.main_master')
@section('content')
 <div class="body-content">
  <div class="container">
   <div class="row">
    @include('frontend.common.user_sidebar')
    <div class="col-md-2">
    </div>
    <div class="col-md-6">
     <div class="card">
      <h3 class="text-center"> <span class="text-danger">Change Your Password</span></h3>
      <div class="card-body">
       <form method="POST" action="{{ route('user.password.update') }}">
        @csrf
        <div class="form-group">
         <label class="info-title">Current Password:</label>
         <input type="password" class="form-control" id="current_password" name="current_password">
        </div>

        <div class="form-group">
         <label class="info-title">New Password:</label>
         <input type="password" class="form-control unicase-form-control text-input" id="password" name="password">
        </div>

        <div class="form-group">
         <label class="info-title">Confirm Password</label>
         <input type="password" class="form-control unicase-form-control text-input" id="password_confirmation"
          name="password_confirmation">
        </div>

        <div class="form-group">

         <button type="submit" class="btn btn-danger">Update</button>
        </div>

       </form>
      </div>
     </div>

    </div>
   </div>
  </div>
 </div>
@endsection
