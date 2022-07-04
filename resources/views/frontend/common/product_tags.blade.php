 @php
  $tags_en = App\Models\Product::groupBy('product_tags_en')
      ->select('product_tags_en')
      ->get();
  $tags_cn = App\Models\Product::groupBy('product_tags_cn')
      ->select('product_tags_cn')
      ->get();

 @endphp
 <!-- ==================== PRODUCT TAGS ================ -->
 <div class="sidebar-widget product-tag wow fadeInUp">
  <h3 class="section-title">Product tags</h3>
  <div class="sidebar-widget-body outer-top-xs">
   <div class="tag-list">
    @if (session()->get('language') == 'chinese')
     @foreach ($tags_cn as $tag)
      <a class="item" title="Phone"
       href="{{ url('product/tag/' . $tag->product_tags_cn) }}">{{ str_replace(',', ' ', $tag->product_tags_cn) }}</a>
     @endforeach
    @else
     @foreach ($tags_en as $tag)
      <a class="item" title="Phone"
       href="{{ url('product/tag/' . $tag->product_tags_en) }}">{{ str_replace(',', ' ', $tag->product_tags_en) }}</a>
     @endforeach

    @endif
   </div>
   <!-- /.tag-list -->
  </div>
  <!-- /.sidebar-widget-body -->
 </div>
 <!-- /.sidebar-widget -->
 <!-- =============== PRODUCT TAGS : END ============= -->
