<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;


class AdminController extends Controller
{
 public function product() {
    return view('admin.product');
 }
 public function uploadproduct(Request $request){
    $data = new Product;

    $image = $request->file('file'); // Corrigé pour récupérer le fichier correctement

    $imagename = now()->timestamp . '.' . $image->getClientOriginalExtension();

    $request->file('file')->move('productimage', $imagename); // Corrigé pour déplacer le fichier

    $data->image = $imagename;

    // Utilisation correcte des champs de la requête
    $data->price = $request->price; 
    $data->description = $request->description; 
    $data->title = $request->title; 
    $data->quantity = $request->quantity;
    $data->category = $request->category;

    $data->save();

    return redirect()->back()->with('message','Product Added sucessfully');
 }
 public function showproduct() {

     $data=product::all();
    return view('admin.showproduct',compact('data'));

 }

 public function deleteProduct($id) {
    $product = Product::find($id);
    $product->delete();
    return redirect()->back()->with('message', 'Product deleted successfully');
    

}
public function updateview($id){
    $data = product::find($id);
    return view('admin.updateview',compact('data'));
}
public function updateproduct(Request $request, $id){
    $data = product::find($id);
    
    $image = $request->file('file'); // Corrigé pour récupérer le fichier correctement
    if($image){

    $imagename = now()->timestamp . '.' . $image->getClientOriginalExtension();

    $request->file('file')->move('productimage', $imagename); // Corrigé pour déplacer le fichier

    $data->image = $imagename;
    }

    // Utilisation correcte des champs de la requête
    $data->price = $request->price; 
    $data->description = $request->description; 
    $data->title = $request->title; 
    $data->quantity = $request->quantity; 

    $data->save();

    return redirect()->back()->with('message','Product Added sucessfully');
}
public function showorder()
{
    $orders = Order::all();

    // Separate single products and configurations
    $singleProducts = $orders->filter(function ($order) {
        return $order->is_single_product;
    });

    $configurations = $orders->filter(function ($order) {
        return !$order->is_single_product;
    })->groupBy('configuration_id');

    return view('admin.showorder', compact('singleProducts', 'configurations'));
}
public function updatestatus($id){
   $order=order::find($id);
   $order->status='delivered';
   $order->save();
   return redirect()->back();
}

}