@extends('admin.admin_master')
@section('admin-content')
 <!-- Content Wrapper. Contains page content -->
 <div class="container-full">
  <!-- Main content -->
  <section class="content">
   <div class="row">
    <div class="col-8">
     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Category List</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
         <thead>
          <tr>
           <th>Category Icon</th>
           <th>Category English</th>
           <th>Category Chinese</th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          @foreach ($category as $item)
           <tr>
            <td><span><i class="{{ $item->category_icon }}"></i></span></td>
            <td>{{ $item->category_name_en }}</td>
            <td>{{ $item->category_name_cn }}</td>
            <td>
             <a href="{{ route('category.edit', $item->id) }}" class="btn btn-info" title="Edit"><i
               class="fa fa-pencil"></i></a>
             <a href="{{ route('category.delete', $item->id) }}" class="btn btn-danger" id="delete"
              title="Delete"><i class="fa fa-trash"></i></a>
            </td>
           </tr>
          @endforeach
         </tbody>
        </table>
       </div>
      </div>
      <!-- /.box-body -->
     </div>
     <!-- /.box -->
    </div>
    <!-- /.col -->


    {{-- ADD CATEGORY PAGE --}}
    <div class="col-4">
     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Add Category</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">

        <form method="post" action="{{ route('category.store') }}">
         @csrf

         <div class="form-group">
          <h5>Category Name English:</h5>
          <div class="controls">
           <input type="text" name="category_name_en" class="form-control">
           @error('category_name_en')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Category Name Chinese:</h5>
          <div class="controls">
           <input type="text" name="category_name_cn" class="form-control">
           @error('category_name_cn')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Category Icon:</h5>
          <div class="controls">
           <input type="text" name="category_icon" class="form-control">
           @error('category_icon')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="text-xs-right">
          <input type="submit" class="btn btn-rounded btn-info" value="Add Category">
         </div>
        </form>
       </div>
      </div>
      <!-- /.box-body -->
     </div>
     <!-- /.box -->
    </div>
   </div>
   <!-- /.row -->
  </section>
  <!-- /.content -->
 </div>
 <!-- /.content-wrapper -->
@endsection
