@extends('admin_master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Variant</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::to('/products')}}">All Products
                                </a></li>
                        <li class="breadcrumb-item active">Add Variant</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Variant</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('store-variants')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                	<input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="row">
                        <div class="col-md-12">
                          <button type="button" class="btn btn-success float-right add-variant my-2"><i class="fa fa-plus"></i> Add New</button>
                          <div class="table-responsive">
                          	<table class="table table-bordered table-striped">
                          	  <thead>
                          	  	<th>Variant Name</th>
                          	  	<th>Variant Value</th>
                          	  	<th>Stock Qty</th>
                          	  	<th>Action</th>
                          	  </thead>	
                          	  <tbody id="contents">
                          	   @if(count($product->variants) > 0)
                          	    @foreach($product->variants as $variant)
                          	    <tr id="{{$variant->id}}">
                          	     <td>
                          	      <input type="text" class="form-control" name="variant_name[]" placeholder="Variant Name" value="{{$variant->variant_name}}"/>	
                          	     </td> 
                          	     <td>
                          	      <input type="text" class="form-control" name="variant_value[]" placeholder="Variant Value" value="{{$variant->variant_value}}"/>	
                          	     </td>	
                          	     <td>
                          	      <input type="text" class="form-control numericInput" name="stock_qty[]" placeholder="Stock Qty" value="{{$variant->stock_qty}}"/>	
                          	     </td>
                          	     <td>
                          	       <button type="button" class="btn btn-danger btn-sm delete-variant" data-id="{{$variant->id}}"><i class="fa fa-trash"></i></button>	
                          	     </td>
                          	    </tr>
                          	    @endforeach
                          	   @else
                          	     <tr>
                          	     <td>
                          	      <input type="text" class="form-control" name="variant_name[]" placeholder="Variant Name" />	
                          	     </td> 
                          	     <td>
                          	      <input type="text" class="form-control" name="variant_value[]" placeholder="Variant Value" />	
                          	     </td>	
                          	     <td>
                          	      <input type="text" class="form-control numericInput" name="stock_qty[]" placeholder="Stock Qty" />	
                          	     </td>

                          	      <td>
                          	       <button type="button" class="btn btn-danger btn-sm" disabled=""><i class="fa fa-trash"></i></button>	
                          	     </td>

                          	    </tr>
                          	   @endif
                          	  </tbody> 
                          	</table>
                          </div>
                        </div>

                        
                        <div class="form-group w-100 px-2">
                            <button type="submit" class="btn btn-primary btn-block">Add Variant</button>
                            <button type="submit" class="btn btn-warning btn-block text-light go-back-products">Go Back</button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')


  <script>
  	$(document).ready(function(){
  		$(document).on('click','.add-variant',function(e){
  			e.preventDefault();
  			let html = `<tr>
              	     <td>
              	      <input type="text" class="form-control" name="variant_name[]" placeholder="Variant Name" />	
              	     </td> 
              	     <td>
              	      <input type="text" class="form-control" name="variant_value[]" placeholder="Variant Value" />	
              	     </td>	
              	     <td>
              	      <input type="text" class="form-control numericInput" name="stock_qty[]" placeholder="Stock Qty" />	
              	     </td>

              	      <td>
              	       <button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-trash"></i></button>	
              	     </td>

              	    </tr>`;
           $('#contents').append(html);
  		});

  		$('.go-back-products').click(function(){
  			window.history.back();
  		});


  		$(document).on('click','.delete-variant',function(e){
  			e.preventDefault();
  			let variant_id = $(this).data('id');
  			if(confirm('Do you want to delete this?'))
  			{
  				$.ajax({

	                url: "{{url('/delete-variant')}}",

	                     type:"POST",
	                     data:{'variant_id':variant_id},
	                     dataType:"json",
	                     success:function(data) {

	                     	$('#'+variant_id).remove();
	                        toastr.success(data.message);

	                },
		                            
		        }); 
  			}
  		});

  		$(document).on('click','.remove-variant',function(e){
  			e.preventDefault();
  			$(this).closest('tr').remove();
  		});

  	});
  </script>

@endpush