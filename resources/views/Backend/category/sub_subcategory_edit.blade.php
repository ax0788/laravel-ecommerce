@extends('admin.admin_master')
@section('admin-content')
 <!-- Content Wrapper. Contains page content -->
 <div class="container-full">
  <!-- Main content -->
  <section class="content">
   <div class="row">
    {{-- ADD Sub-SubCategory PAGE --}}
    <div class="col-12">
     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Edit Sub-SubCategory</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">
        <form method="post" action="{{ route('subsubcategory.update') }}">
         @csrf
         <input type="hidden" name="id" value="{{ $subsubcategories->id }}">
         <div class="form-group">
          <h5>Category Select <span class="text-danger">*</span></h5>
          <div class="controls">
           <select name="category_id" class="form-control">
            <option selected disabled>Select Category</option>
            @foreach ($categories as $category)
             <option value="{{ $category->id }}"
              {{ $category->id == $subsubcategories->category_id ? 'selected' : '' }}>
              {{ $category->category_name_en }}
             </option>
            @endforeach
           </select>
           @error('category_id')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>SubCategory Select <span class="text-danger">*</span></h5>
          <div class="controls">
           <select name="subcategory_id" class="form-control">
            <option selected disabled>Select SubCategory</option>
            @foreach ($subcategories as $subcat)
            <option value="{{ $subcat->id }}" {{ $subcat->id == $subsubcategories->subcategory_id ? 'selected' : ''}}>{{ $subcat->subcategory_name_en }}
            </option>
           @endforeach
           </select>
           @error('subcategory_id')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>



         <div class="form-group">
          <h5>Sub-SubCategory English:</h5>
          <div class="controls">
           <input type="text" name="subsubcategory_name_en" class="form-control"
            value="{{ $subsubcategories->subsubcategory_name_en }}">
           @error('subsubcategory_name_en')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Sub-SubCategory Chinese:</h5>
          <div class="controls">
           <input type="text" name="subsubcategory_name_cn" class="form-control"
            value="{{ $subsubcategories->subsubcategory_name_cn }}">
           @error('ssububcategory_name_cn')
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
   </div>
   <!-- /.row -->
  </section>
  <!-- /.content -->
 </div>
 <!-- /.content-wrapper -->
@endsection
