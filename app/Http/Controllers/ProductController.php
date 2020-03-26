<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\Image;
use DB;


class ProductController extends Controller
{
    function create(){

        return view('products');

    }

    function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:60',
            'price' => 'required|string',
            'description'=> 'required|string',
        ]);

        if(Product::store($request) == 0)
            return back()->with('success','Produto adicionado com sucesso!');
        
        else return back()->with('error','Um erro foi encontrado, tente novamente!');

    }

    function settings(){

        return view('settings', ['products' => Product::settings()->get()->toArray()]);

    }

    function edit(Request $request){

        $data = $request->input();

        return Product::edit($data);
        

    }

    function editImage(Request $request){

        if(Image::editImage($request) == 1)
            return back()->with('error','Imagem não encontrada!');
        
        return back()->with('success','Imagem alterada com sucesso!');

    }

    function destroy(Request $request){

        $data = $request->input();

        return Product::destroy($data);

    }

    function details($id){

        return view('details', ['products' => Product::list($id)]);



    }

}
