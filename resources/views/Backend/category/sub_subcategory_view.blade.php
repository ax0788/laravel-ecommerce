@extends('admin.admin_master')
@section('admin-content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
 <!-- Content Wrapper. Contains page content -->
 <div class="container-full">
  <!-- Main content -->
  <section class="content">
   <div class="row">
    <div class="col-8">
     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Sub-SubCategory List</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
         <thead>
          <tr>
           <th>Category</th>
           <th>SubCategory</th>
           <th>Sub-SubCategory</th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          @foreach ($subsubcategory as $item)
           <tr>
            {{-- Created a subcategory belongsTo Category. --}}
            {{-- Display from category table, category_name_en column data --}}
            <td>{{ $item['category']['category_name_en'] }}</td>
            <td>{{ $item['subcategory']['subcategory_name_en'] }}</td>
            <td>{{ $item->subsubcategory_name_en }}</td>
            <td width="30%">
             <a href="{{ route('subsubcategory.edit', $item->id) }}" class="btn btn-info" title="Edit"><i
               class="fa fa-pencil"></i></a>
             <a href="{{ route('subsubcategory.delete', $item->id) }}" class="btn btn-danger" id="delete"
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


    {{-- ADD Sub-SubCategory PAGE --}}
    <div class="col-4">
     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Add Sub-SubCategory</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">

        <form method="post" action="{{ route('subsubcategory.store') }}">
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
            <h5>SubCategory Select <span class="text-danger">*</span></h5>
            <div class="controls">
             <select name="subcategory_id" class="form-control">
              <option selected disabled>Select SubCategory</option>
             </select>
             @error('subcategory_id')
              <span class="text-danger">{{ $message }}</span>
             @enderror
            </div>
           </div>



         <div class="form-group">
          <h5>Sub-SubCategory English:</h5>
          <div class="controls">
           <input type="text" name="subsubcategory_name_en" class="form-control">
           @error('subsubcategory_name_en')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Sub-SubCategory Chinese:</h5>
          <div class="controls">
           <input type="text" name="subsubcategory_name_cn" class="form-control">
           @error('ssububcategory_name_cn')
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

 <script>
    // On selecting Category list item from option drop down, and if there are any category items,  then get the data of the subcategory with json type
     $(document).ready(function() {
        $('select[name="category_id"]').on('change', function(){
            const category_id = $(this).val();
            if(category_id) {
                $.ajax({
                    url: "{{  url('/category/subcategory/ajax') }}/"+category_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                       const d =$('select[name="subcategory_id"]').empty();
                          $.each(data, function(key, value){
                              $('select[name="subcategory_id"]').append('<option value="'+ value.id +'">' + value.subcategory_name_en + '</option>');
                          });
                    },
                });
            } else {
                alert('danger');
            }
        });
    });
 </script>
@endsection
