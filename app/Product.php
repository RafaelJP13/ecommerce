<?php

namespace App;
use Auth;
use App\Image;
use App\User;
use DB;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'description', 'user'
    ];

    static function store($request){

        $images = $request->file('images');
        $price  = str_replace(",",".",$request->input('price'));

        if(preg_match('/^[0-9.]+$/', $price) == 0)
            return 1;
        else{
        
            $data = array(
                'name'        => $request->input('name'),
                'price'       => $price,
                'description' => $request->input('description'),
                'user'        => Auth::user()->id
            );

            $id = Product::create($data)->id;

            foreach($images as $image){

                $filename = time() . '_' .$image->getClientOriginalName();
                $image->move('images/products/', $filename);

                Image::store($id, $filename);

            }

            if($id > 0 ) return 0;
            
            return 1;
        }
        
    }

    static function settings(){

        $type = User::where('id', Auth::user()->id)->get()[0]->type;
        $AProducts = array();

        $products =  $type == 1 ? DB::table('products')->select('id','name', 'price', 'status','description')->get(): DB::table('products')->select('id','name', 'price', 'description', 'status')->where('user', Auth::user()->id)->get();

            for($i = 0; $i < count($products); $i++){

                $images = DB::table('images')->where('product', $products[$i]->id)->get();

                $product = ([

                    'id' => $products[$i]->id,
                    'name' => $products[$i]->name,
                    'price' => number_format($products[$i]->price, 2, ',', '.'),
                    'status' => $products[$i]->status,
                    'description' => $products[$i]->description,
                    'images' => $images,
                    'userType' => $type

                ]);

                array_push($AProducts,$product);
            }

            return $AProducts;

    }

    static function edit($data){

        
        $option = $data['option'];
        $value  = $data['value'];
        $id     = $data['id'];
    
        $product = Product::find($id);

        if($option == 1) $product->name = $value;
        else if($option == 2) $product->price = str_replace(",",".",$value);
        else if($option == 3) $product->description = $value;
        else $product->status = $value;
        $product->save();
        
    }

    static function destroy($data){

        $images = DB::table('images')->select('name')->where('product', $data['id'])->get();

        for($i = 0; $i < count($images); $i++){

            unlink('images/products/' . $images[$i]->name);
        }

        DB::table('images')->where('product', $data['id'])->delete();

        DB::table('products')->where('id', $data['id'])->delete();

    }

    static function list($id){

        $AProducts = array();

        $products = $id != null ? DB::table('products')->select('id','name', 'price', 'status','description')->where('id', $id)->where('status', 1)->get(): DB::table('products')->select('id','name', 'price', 'status','description')->where('status',1)->get();

            for($i = 0; $i < count($products); $i++){

                $images = DB::table('images')->where('product', $products[$i]->id)->get();

                $product = ([

                    'id' => $products[$i]->id,
                    'name' => $products[$i]->name,
                    'price' => number_format($products[$i]->price, 2, ',', '.'),
                    'description' => $products[$i]->description,
                    'images' => $images,

                ]);

                array_push($AProducts,$product);
            }

            return $AProducts;

    }

}
