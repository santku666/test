<?php
namespace App\Services;

use App\Models\Material;
use App\Models\Qty_management;
use Exception;
use Illuminate\Support\Facades\DB;

class QtyManager{

    public function __construct()
    {
        
    }

    public function getAll()
    {
        $result=Material::with('category')->get();
        return [
            "data"=>$result->toArray(),
            'count'=>$result->count()
        ];
    }

    public function getOne(int $id)
    {
        $result=Material::findOrFail($id);
        return $result;
    }

    public function create($req):bool
    {
        try {
            DB::beginTransaction();
            $create=new Qty_management();
            $create->material_id =$req->input('material_id');
            $create->date=$req->input('date');
            $create->qty=$req->input('qty');
            $create->save();
            
            $material_Service=new Materials();
            $update_blc=$material_Service->update_current_blc($req->input('material_id'),$req->input('qty'));
            if ($create && $update_blc) {
                DB::commit();
                return true;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
        
    }

    // public function update($req,int $id)
    // {
    //     $update=Material::where('id',$id)->update([
    //         'name'=>$req->input('name'),
    //         'category_id'=>$req->input('category_id'),
    //         'opening_blc'=>$req->input('opening_blc')
    //     ]);
    //     return true;
    // }

    // public function delete(int $id)
    // {
    //     $delete=Material::where('id',$id)->delete();
    //     return true;
    // }
}
?>