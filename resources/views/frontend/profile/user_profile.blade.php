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
      <h3 class="text-center"><span class="text-danger">Hi, </span><strong>{{ Auth::user()->name }} </strong> Update user
       profile!</h3>
      <div class="card-body">
       <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
         <label class="info-title">Name:</label>
         <input type="text" class="form-control" name="name" value="{{ $user->name }}">
        </div>

        <div class="form-group">
         <label class="info-title">Email Address:</label>
         <input type="email" class="form-control unicase-form-control text-input" name="email"
          value="{{ $user->email }}">
        </div>

        <div class="form-group">
         <label class="info-title">Phone:</label>
         <input type="text" class="form-control unicase-form-control text-input" name="phone"
          value="{{ $user->phone }}">
        </div>
        <div class="form-group">
         <label class="info-title">User Image:</label>
         <input type="file" class="form-control unicase-form-control text-input" name="profile_photo_path">
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
