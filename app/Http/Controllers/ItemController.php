<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\User;
use Excel;
use App\Item;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::where('item_status',Auth::user()->id)->paginate(45);
        return view('items',compact('items'));
    }
    public function search(){


        $s = Input::get('category');

       // $s = $request->input('category');
         /* $items = Item::Where('item_status',Auth::user()->id)->where('item_tax', 'like', "%$s%")
                
                ->paginate(1);
*/


                $items = Item::Where('item_status',Auth::user()->id)->Where( 'item_name', 'LIKE', '%' . $s . '%' )->paginate(5);

                $pagination = $items->appends ( array (
                    'category' => Input::get ( 'category' ) 
                ) );





                return view('items',compact('items'));
      //  return view('search', ['items' => $items, 's' => $s ]);
            }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function import(Request $request)
    {
      if($request->file('imported-file'))
      {
        $path = $request->file('imported-file')->getRealPath();
        $data = Excel::load($path, function($reader)
        {
        })->get();
        if($data->count() > 0){
            $count = ceil($data->count()/1000);

            for($i=0;$i<$count;$i++){
                $start = $i ===0 ? 0 : $i*1000;
                $dataArray = [];
                foreach ($data->slice($start, 1000) as $row) {
                    $dataArray[] =
                    [
                      'item_name' => $row->item_name,
                      'item_code' => $row->item_code,
                      'item_price' => $row->item_price,
                      'item_qty' => $row->item_qty,
                      'item_tax' => $row->item_tax,
                      /*'item_status' => $row['item_status'],*/
                      'item_status' => $id = Auth::user()->id,
                      'created_at' => $row->created_at
                    ];
                }
                Item::insert($dataArray);
            }
        }
  return back();
    }
}


public function export(){
     // $items = Item::all();
    $items=    Item::where('item_status',Auth::user()->id)->get();
    Excel::create('items', function($excel) use($items) {
      $excel->sheet('ExportFile', function($sheet) use($items) {
          $sheet->fromArray($items);
      });
  })->export('csv');

}
}
