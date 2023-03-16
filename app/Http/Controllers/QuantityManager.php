<?php

namespace App\Http\Controllers;

use App\Helpers\Collection;
use App\Services\Categories;
use App\Services\QtyManager as QtyManagerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuantityManager extends Controller
{
    protected $qty_management_Service;
    public function __construct()
    {
        $this->qty_management_Service=new QtyManagerService();
    }

    /**
     * ---------------------------------
     *  this method will return the list of entries  made for quantites
     * ----------------------------------
     * */ 
    public function index(Request $req)
    {
        try {
            $result=$this->qty_management_Service->getAll();
            $collection=new Collection($result['data']);
            $result=$collection->paginate(10);
            return view('qty-management.index',compact('result'));
        } catch (Exception $e) {
            echo "Error Occured ".$e->getMessage()." on line ".$e->getLine()." file".$e->getFile();
            exit;
        }
    }

    public function create(Request $req)
    {
        $category_service=new Categories();
        $categories=$category_service->getAll();
        return view('qty-management.entry',compact('categories'));
    }

    public function store(Request $req)
    {
        try {
            $validator=Validator::make($req->all(),[
                "material_id"=>["required","numeric"],
                'date'=>["required"],
                "qty"=>["required","numeric"]
            ],[
                "material_id.required"=>"Material is Mandatory",
                "date.required"=>"Date is Mandatory",
                "qty.required"=>"Qty is Mandatory",
                "qty.numeric"=>"Qty must be Numeric value",
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status_code'=>500,
                    'message'=>$validator->errors(),
                ],500);
            } else {
                $result=$this->qty_management_Service->create($req);
                if ($result==true) {
                    return response()->json([
                        'status_code'=>200,
                        'message'=>"record created successfully",
                    ],200);
                }else {
                    return response()->json([
                        'status_code'=>500,
                        'message'=>"failed to create record",
                    ],500);
                }
            }
            
        } catch (Exception $e) {
            echo "Error Occured ".$e->getMessage()." on line ".$e->getLine()." file ".$e->getFile();
            exit;
        }
    }
    
}
