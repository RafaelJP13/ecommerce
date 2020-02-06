<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Image extends Model
{
    protected $fillable = [
        'name', 'product'
    ];

    static function store($idProduct, $filename){

        $data = array(
            'name'    => $filename,
            'product' => $idProduct
        );

        Image::create($data);

    }

    static function editImage($request){

        if($request['imageUpload'] == null) return 1;

        $image       = $request->file('imageUpload');
        $oldFileName = $request['imageName'];
        $fileName    = time() . '_' .$image->getClientOriginalName();

        unlink('images/products/' . $oldFileName);
        $image->move('images/products/', $fileName);

        DB::table('images')
            ->where('name', $oldFileName)
            ->update(['name' => $fileName]);
    }

}
