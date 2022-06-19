@extends('admin.admin_master')
@section('admin-content')
 <!-- Content Wrapper. Contains page content -->
 <div class="container-full">
  <!-- Main content -->
  <section class="content">
   <div class="row">
    {{-- ADD SubCategory PAGE --}}
    <div class="col-12">
     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Add Subcategory</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">

        <form method="post" action="{{ route('subcategory.update') }}">
         @csrf
         <input type="hidden" name="id" value="{{ $subcategory->id }}">
         <div class="form-group">
          <h5>Category Select <span class="text-danger">*</span></h5>
          <div class="controls">
           <select name="category_id" class="form-control">
            <option selected disabled>Select Category</option>
            @foreach ($categories as $category)
            {{-- When categories table id match with subcategories category_id column ids, then that will be selcted --}}
             <option value="{{ $category->id }}" {{ $category->id == $subcategory->category_id ? 'selected' : '' }} >{{ $category->category_name_en }}
             </option>
            @endforeach
           </select>
           @error('category_id')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>
         <div class="form-group">
          <h5>Subcategory English:</h5>
          <div class="controls">
           <input type="text" name="subcategory_name_en" class="form-control" value="{{ $subcategory-> subcategory_name_en}}">
           @error('subcategory_name_en')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Subcategory Chinese:</h5>
          <div class="controls">
           <input type="text" name="subcategory_name_cn" class="form-control" value="{{ $subcategory-> subcategory_name_cn}}">
           @error('subcategory_name_cn')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>
         <div class="text-xs-right">
          <input type="submit" class="btn btn-rounded btn-info" value="Add Subcategory">
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
