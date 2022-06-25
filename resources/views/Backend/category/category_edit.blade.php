@extends('admin.admin_master')
@section('admin-content')
 <!-- Content Wrapper. Contains page content -->
 <div class="container-full">

  <!-- Main content -->
  <section class="content">
   <div class="row">

    <div class="col-1">
    </div>


    {{-- ADD category PAGE --}}

    <div class="col-10">

     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Edit category</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">
        <form method="post" action="{{ route('category.update', $category->id) }}">
         @csrf
         <input type="hidden" name="id" value="{{ $category->id }}">
         <div class="form-group">
          <h5>Category Name in English:</h5>
          <div class="controls">
           <input type="text" name="category_name_en" class="form-control"
            value="{{ $category->category_name_en }}">
           @error('category_name_en')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Category Name in Chinese:</h5>
          <div class="controls">
           <input type="text" name="category_name_cn" class="form-control"
            value="{{ $category->category_name_cn }}">
           @error('category_name_cn')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>
         <div class="form-group">
          <h5>Category Icon:</h5>
          <div class="controls">
           <input type="text" name="category_icon" class="form-control" value="{{ $category->category_icon }}">
           @error('category_icon')
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
