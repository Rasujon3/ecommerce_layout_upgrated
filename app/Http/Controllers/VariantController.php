<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class VariantController extends Controller
{   

	public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function addVariant($id)
    {   
    	$product = Product::findorfail($id);
    	return view('products.add_variant',compact('product'));
    }

    public function storeVariants(Request $request)
	{
	    try {
	        $productId = $request->input('product_id');

	        // Clean and align inputs
	        $names = $request->input('variant_name', []);
	        $values = $request->input('variant_value', []);
	        $quantities = $request->input('stock_qty', []);

	        $variantsToUpsert = [];

	        for ($i = 0; $i < count($names); $i++) {
	            // Skip empty rows
	            if (empty($names[$i]) || empty($values[$i]) || $quantities[$i] === null || $quantities[$i] === '') {
	                continue;
	            }

	            $variantsToUpsert[] = [
	                'product_id'     => $productId,
	                'variant_name'   => $names[$i],
	                'variant_value'  => $values[$i],
	                'stock_qty'      => $quantities[$i],
	                'created_at'     => now(),
	                'updated_at'     => now(),
	            ];
	        }

	        if (empty($variantsToUpsert)) {
	            return redirect()->back()->with([
	                'messege' => 'Please add at least one valid variant',
	                'alert-type' => 'error',
	            ]);
	        }

	        // Upsert: insert or update existing entries based on unique constraint
	        DB::table('variants')->upsert(
	            $variantsToUpsert,
	            ['product_id', 'variant_name', 'variant_value'], // Unique constraint fields
	            ['stock_qty', 'updated_at'] // Fields to update if match found
	        );

	        return redirect('/products')->with([
	            'messege' => 'Variants added/updated successfully',
	            'alert-type' => 'success',
	        ]);

	    } catch (Exception $e) {
	        return response()->json([
	            'status' => true,
	            'code' => $e->getCode(),
	            'message' => $e->getMessage(),
	        ], 500);
	    }
	}


}
