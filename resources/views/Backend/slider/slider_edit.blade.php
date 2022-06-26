@extends('admin.admin_master')
@section('admin-content')
 <!-- Content Wrapper. Contains page content -->
 <div class="container-full">

  <!-- Main content -->
  <section class="content">
   <div class="row">

    <div class="col-1">
    </div>

    {{-- ADD SLIDER --}}
    <div class="col-10">

     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Edit Slider</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">
        <form method="post" action="{{ route('slider.update') }}" enctype="multipart/form-data">
         @csrf
         <input type="hidden" name="id" value="{{ $sliders->id }}">
         <input type="hidden" name="old_image" value="{{ $sliders->slider_img }}">
         <div class="form-group">
          <h5>Slider Title</h5>
          <div class="controls">
           <input type="text" name="title" class="form-control" value="{{ $sliders->title }}">
          </div>
         </div>

         <div class="form-group">
          <h5>Slider Description</h5>
          <div class="controls">
           <input type="text" name="description" class="form-control" value="{{ $sliders->description }}">
          </div>
         </div>


         <div class="form-group">
          <h5>Slider Image</h5>
          <div class="controls">
           <input type="file" name="slider_img" class="form-control">
           @error('slider_img')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="text-xs-right">
          <input type="submit" class="btn btn-rounded btn-info" value="Update">
         </div>
        </form>

       </div>
      </div>
      <!-- /.box-body -->
     </div>
     <!-- /.box -->

    </div>

    <div class="col-1">
    </div>
   </div>
   <!-- /.row -->
  </section>
  <!-- /.content -->

 </div>

 <!-- /.content-wrapper -->
@endsection
