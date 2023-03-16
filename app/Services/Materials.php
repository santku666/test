<?php
namespace App\Services;

use App\Models\Material;

class Materials{

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

    public function getbyCategory(int $category_id)
    {
        $result=Material::where('category_id',$category_id)->get();
        return [
            'data'=>$result->toArray(),
            'count'=>$result->count()
        ];
    }

    public function create($req):bool
    {
        $create=new Material();
        $create->name=sanatize($req->input('name'));
        $create->category_id=$req->input('category_id');
        $create->opening_blc=$req->input('opening_blc');
        $create->current_blc=$req->input('opening_blc');
        if ($create->save()) {
            return true;
        } else {
            return false;
        }
        
    }

    public function update($req,int $id)
    {
        $update=Material::where('id',$id)->update([
            'name'=>sanatize($req->input('name')),
            'category_id'=>$req->input('category_id'),
            'opening_blc'=>$req->input('opening_blc')
        ]);
        return true;
    }

    public function delete(int $id)
    {
        $delete=Material::where('id',$id)->delete();
        return true;
    }

    public function update_current_blc($material_id,$input_blc):bool
    {   
        $get_current_blc=Material::where('id',$material_id)->first(['id','current_blc']);
        $current_blc=$get_current_blc?->current_blc + ($input_blc);
        $update_blc=Material::where('id',$material_id)->update([
            'current_blc'=>$current_blc
        ]);
        return true;
    }
}
?>