<?php

namespace App\Http\Controllers;

use App\Helpers\Collection;
use App\Services\Categories as CategoryService;
use App\Services\Materials as MaterialService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Material extends Controller
{

    protected $material_service;
    public function __construct()
    {
        $this->material_service=new MaterialService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result=$this->material_service->getAll();
        $list=new Collection($result['data']);
        $result=$list->paginate(10);
        return view('materials.index',compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_service=new CategoryService();
        $categories=$category_service->getAll();
        return view('materials.add',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator=Validator::make($request->all(),[
                'name'=>["required","max:100"],
                'category_id'=>["required"],
                "opening_blc"=>["required","numeric"]
            ],[
                "name.required"=>"Material Name is Mandatory",
                "name.max"=>"Material Name must be Maximum 100 Characters",
                "category_id.required"=>"Select a Category",
                "opening_blc.required"=>"Opening Balance is Mandatory",
                "opening_blc.numeric"=>"Opening Balance must be Numeric Value"
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
            } else {
                $create=$this->material_service->create($request);
                if ($create===true) {
                    return redirect('/materials')->with('success','record created successfully');
                }else {
                    return redirect()->back()->with('error','failed to create record');
                }
            }
        } catch (Exception $e) {
            echo "Error Occured ".$e->getMessage()." on Line ".$e->getLine()." file".$e->getFile();
            exit;
        }
        
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
        $category_service=new CategoryService();
        $categories=$category_service->getAll();
        $data=$this->material_service->getOne($id);
        return view('materials.edit',compact('categories','data'));
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
        try {
            $validator=Validator::make($request->all(),[
                'name'=>["required","max:100"],
                'category_id'=>["required"],
                "opening_blc"=>["required","numeric"]
            ],[
                "name.required"=>"Material Name is Mandatory",
                "name.max"=>"Material Name must be Maximum 100 Characters",
                "category_id.required"=>"Select a Category",
                "opening_blc.required"=>"Opening Balance is Mandatory",
                "opening_blc.numeric"=>"Opening Balance must be Numeric Value"
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
            } else {
                $update=$this->material_service->update($request,$id);
                if ($update===true) {
                    return redirect('/materials')->with('success','record updated successfully');
                } else {
                    return redirect()->back()->with('error','failed to update record');
                }
                
            }
            
        } catch (Exception $e) {
            echo "Error Occured".$e->getMessage()." on Line ".$e->getLine()." file".$e->getFile();
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=$this->material_service->delete($id);
        return redirect('/materials')->with('success','record deleted successfully');
    }

    public function materials_by_category($category_id)
    {
        $result=$this->material_service->getbyCategory($category_id);
        return response()->json([
            'status_code'=>200,
            'serverData'=>$result
        ],200);
    }

}
