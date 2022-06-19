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
       <h3 class="box-title">SubCategory List</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
         <thead>
          <tr>
           <th>Category</th>
           <th>SubCategory English</th>
           <th>SubCategory Chinese</th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          @foreach ($subcategory as $item)
           <tr>
            {{-- Created a subcategory belongsTo Category. --}}
            {{-- Display from category table, category_name_en column data --}}
            <td>{{ $item['category']['category_name_en'] }}</td>
            <td>{{ $item->subcategory_name_en }}</td>sub
            <td>{{ $item->subcategory_name_cn }}</td>
            <td>
             <a href="{{ route('subcategory.edit', $item->id) }}" class="btn btn-info" title="Edit"><i
               class="fa fa-pencil"></i></a>
             <a href="{{ route('subcategory.delete', $item->id) }}" class="btn btn-danger" id="delete"
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


    {{-- ADD SubCATEGORY PAGE --}}
    <div class="col-4">
     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Add Subcategory</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">

        <form method="post" action="{{ route('subcategory.store') }}">
         @csrf
         <div class="form-group">
          <h5>Category Select <span class="text-danger">*</span></h5>
          <div class="controls">
           <select name="category_id" class="form-control">
            <option selected disabled>Select Category</option>
            @foreach ($categories as $category)
             <option value="{{ $category->id }}">{{ $category->category_name_en }}
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
           <input type="text" name="subcategory_name_en" class="form-control">
           @error('subcategory_name_en')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Subcategory Chinese:</h5>
          <div class="controls">
           <input type="text" name="subcategory_name_cn" class="form-control">
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
