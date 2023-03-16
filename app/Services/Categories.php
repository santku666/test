<?php
namespace App\Services;

use App\Models\Category;

class Categories{

    public function __construct()
    {
        
    }

    public function getAll()
    {
        $result=Category::get();
        return [
            "data"=>$result->toArray(),
            'count'=>$result->count()
        ];
    }

    public function getOne(int $id)
    {
        $result=Category::findOrFail($id);
        return $result;
    }

    public function create($req):bool
    {
        $create=new Category();
        $create->name=sanatize($req->input('name'));
        if ($create->save()) {
            return true;
        } else {
            return false;
        }
        
    }

    public function update($req,int $id)
    {
        $update=Category::where('id',$id)->update([
            'name'=>sanatize($req->input('name'))
        ]);
        return true;
    }

    public function delete(int $id)
    {
        $delete=Category::where('id',$id)->delete();
        return true;
    }
}
?>