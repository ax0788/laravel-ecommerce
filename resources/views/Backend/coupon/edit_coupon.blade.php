@extends('admin.admin_master')
@section('admin-content')
 <!-- Content Wrapper. Contains page content -->
 <div class="container-full">
  <!-- Main content -->
  <section class="content">
   <div class="row">

    {{-- ADD COUPON PAGE --}}
    <div class="col-12">
     <div class="box">
      <div class="box-header with-border">
       <h3 class="box-title">Edit Coupon</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
       <div class="table-responsive">

        <form method="post" action="{{ route('coupon.update', $coupons->id) }}">
         @csrf

         <div class="form-group">
          <h5>Coupon Name</h5>
          <div class="controls">
           <input type="text" name="coupon_name" class="form-control" value="{{ $coupons->coupon_name }}">
           @error('coupon_name')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Coupon Discount(%)</h5>
          <div class="controls">
           <input type="text" name="coupon_discount" class="form-control" value="{{ $coupons->coupon_discount }}">
           @error('coupon_discount')
            <span class="text-danger">{{ $message }}</span>
           @enderror
          </div>
         </div>

         <div class="form-group">
          <h5>Coupon Validity</h5>
          <div class="controls">
           <input type="date" name="coupon_validity" class="form-control"
            min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $coupons->coupon_validity }}">
           @error('coupon_validity')
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
