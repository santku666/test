<?php

namespace App\Http\Controllers;

use App\Helpers\Collection;
use App\Services\Categories as CategoryService;
use App\Services\Materials as MaterialService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Category extends Controller
{
    protected $categories_Service;
    public function __construct()
    {
        $this->categories_Service=new CategoryService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result=$this->categories_Service->getAll();
        $list=new Collection($result['data']);
        $result=$list->paginate(10);
        return view('categories.index',compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.add');
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
                'name'=>["required","max:100"]
            ],[
                "name.required"=>"Category Name is Mandatory",
                "name:max"=>"Category Name must be of maximum 100 Characters"
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
            } else {
                $create=$this->categories_Service->create($request);
                if ($create==true) {
                    return redirect('/categories')->with('success','record created successfully');
                }else{
                    return redirect()->back()->with('error','failed to create new record');
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
        $data=$this->categories_Service->getOne($id);
        return view('categories.edit',compact('data'));
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
        $validator=Validator::make($request->all(),[
            'name'=>["required","max:100","string"]
        ],[
            "name.required"=>"Category Name is Mandatory",
            "name:max"=>"Category Name must be of maximum 100 Characters",
            "name:string"=>"Category Name must be String"
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        }else{
            
            $update=$this->categories_Service->update($request,$id);
            if ($update==true) {
                return redirect('/categories')->with('success','record updated successfully');
            } else {
                return redirect()->back()->with('error','failed to update record');
            }
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
        $delete=$this->categories_Service->delete($id);
        $material_service=new MaterialService(); //initializing material service
        $materialsbycategory=$material_service->getbyCategory($id); //getting all materials by category id
        foreach ($materialsbycategory['data'] as $key => $value) {  //delete all the materials found
            $material_service->delete($value['id']);
        }
        return redirect('/categories')->with('success','record deleted successfully');
    }
}
