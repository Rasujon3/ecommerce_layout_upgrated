<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhyChooseUsRequest;
use App\Models\WhyChooseUs;
use Exception;
use Illuminate\Http\Request;
use DataTables;

class WhyChooseUsController extends Controller
{
    public function index(Request $request)
    {
//        $items = WhyChooseUs::latest()->get();
//        return view('admin.why_choose_us.index', compact('items'));

        try
        {
            if($request->ajax()){

                $whyChooseUs = WhyChooseUs::select('*')->latest();

                return Datatables::of($whyChooseUs)
                    ->addIndexColumn()

                    ->addColumn('description', function($row){
                        return $row->description;
                    })

                    ->addColumn('action', function($row){

                        $btn = "";
                        $btn .= '&nbsp;';
                        $btn .= ' <a href="'.route('why_choose_us.edit',$row->id).'" class="btn btn-primary btn-sm action-button edit-service" data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';

                        $btn .= '&nbsp;';

                        $btn .= ' <a href="#" class="btn btn-danger btn-sm delete-service action-button" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';

                        return $btn;
                    })

                    ->rawColumns(['description', 'action'])
                    ->make(true);
            }
            return view('whyChooseUs.index');
        } catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function create()
    {
        return view('whyChooseUs.create');
    }

    public function store(WhyChooseUsRequest $request)
    {
        try
        {
            WhyChooseUs::create([
                'description' => $request->description,
            ]);
            $notification = array(
                'messege' => 'Successfully a item has been added',
                'alert-type' => 'success',
            );

            return redirect()->route('why_choose_us.index')->with($notification);
        } catch(Exception $e) {
            return response()->json([
                'status'=>false,
                'code'=>$e->getCode(),
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function edit($id)
    {
        $item = WhyChooseUs::findOrFail($id);
        return view('whyChooseUs.edit', compact('item'));
    }

    public function update(WhyChooseUsRequest $request, WhyChooseUs $whyChooseUs)
    {
        try
        {
            $whyChooseUs->description = $request->description;
            $whyChooseUs->save();
            $notification=array(
                'messege' => 'Successfully the item has been updated',
                'alert-type' => 'success',
            );

            return redirect()->route('why_choose_us.index')->with($notification);

        } catch(Exception $e) {
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function destroy(WhyChooseUs $whyChooseUs)
    {
        try
        {
            $whyChooseUs->delete();
            $notification=array(
                'messege' => 'Successfully the item has been deleted.',
                'alert-type' => 'success',
            );

            return redirect()->route('why_choose_us.index')->with($notification);

        } catch(Exception $e) {
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}

