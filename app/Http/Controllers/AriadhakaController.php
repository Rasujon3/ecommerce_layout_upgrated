<?php

namespace App\Http\Controllers;

use App\Models\Ariadhaka;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest; 
use DataTables;

class AriadhakaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function index(Request $request)
    {
        try
        {
            if($request->ajax()){

               $ariadhakas = Ariadhaka::where('user_id',user()->id)->select('*')->latest();

                    return Datatables::of($ariadhakas)
                        ->addIndexColumn()


                        ->addColumn('status', function($row){
                            return '<label class="switch"><input class="' . ($row->status == 'Active' ? 'active-aria' : 'decline-aria') . '" id="status-aria-update"  type="checkbox" ' . ($row->status == 'Active' ? 'checked' : '') . ' data-id="'.$row->id.'"><span class="slider round"></span></label>';
                        })
                       
                        ->addColumn('action', function($row){
                                                        
                           $btn = "";
                           $btn .= '&nbsp;';
                           $btn .= ' <a href="'.route('ariadhakas.show',$row->id).'" class="btn btn-primary btn-sm action-button edit-aria" data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';

                            $btn .= '&nbsp;';


                            $btn .= ' <a href="#" class="btn btn-danger btn-sm delete-aria action-button" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>'; 
        
                          
        
                            return $btn;
                        })
                        ->rawColumns(['action','status'])
                        ->make(true);
            }
            return view('areas.index');
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('areas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAreaRequest $request)
    {
        try
        {
            $area = new Ariadhaka();
            $area->user_id = user()->id;
            $area->area_name = $request->area_name;
            $area->area_type = $request->area_type;
            $area->status = $request->status;
            $area->save();
            $notification=array(
                'messege'=>'Successfully an area has been added',
                'alert-type'=>'success',
            );

            return redirect()->back()->with($notification);
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ariadhaka  $ariadhaka
     * @return \Illuminate\Http\Response
     */
    public function show(Ariadhaka $ariadhaka)
    {
        return view('areas.edit', compact('ariadhaka'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ariadhaka  $ariadhaka
     * @return \Illuminate\Http\Response
     */
    public function edit(Ariadhaka $ariadhaka)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ariadhaka  $ariadhaka
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAreaRequest $request, Ariadhaka $ariadhaka)
    {
        try
        {
            $ariadhaka->area_name = $request->area_name;
            $ariadhaka->area_type = $request->area_type;
            $ariadhaka->status = $request->status;
            $ariadhaka->update();
            $notification=array(
                'messege'=>'Successfully the area has been updated',
                'alert-type'=>'success',
            );

            return redirect()->route('ariadhakas.index')->with($notification);
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ariadhaka  $ariadhaka
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ariadhaka $ariadhaka)
    {
        try
        {
            $ariadhaka->delete();
            return response()->json(['status'=>true, 'message'=>'Successfully the aria has been deleted']);
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
