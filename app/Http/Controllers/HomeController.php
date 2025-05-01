<?php

namespace App\Http\Controllers;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use PDF;
class HomeController extends Controller
{
    public function redirect(){
        $usertype=Auth::user()->usertype;
        
        if($usertype=='1'){
            return view('admin.home');
        } else {

            $data= product::all();
            $user = auth()->user();
            $count= cart::where('phone',$user->phone)->count();
            return view('User.home',compact('data','count'));
        }
    }

    public function index() {
   
    if(Auth::id()) {
        return redirect('redirect');
    } 
    else{

         $data= product::paginate(3);
        return view('User.home',compact('data'));
    }
        
    }
    public function search(Request $request)
{
    $user = auth()->user();
    $count= cart::where('phone',$user->phone)->count();
    $search = $request->input('search');
    $data = Product::where('title', 'like', '%' . $search . '%')->get();
    return view('User.home', compact('data','count'));
}
public function addcart(Request $request, $id)
{
    if (Auth::check()) {
        $user = auth()->user();
        $product = Product::find($id);
        if ($product) {
            $cart = new Cart;
             // Associate cart item with the user
            $cart->name = $user->name;
            $cart->phone = $user->phone;
            $cart->address = $user->address;
            $cart->product_title = $product->title;
            $cart->price = $product->price;
            $cart->quantity = $request->input('quantity', 1); // Default quantity to 1 if not provided
            $cart->save();

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } else {
            return redirect()->back()->with('error', 'Product not found.');
        }
    } else {
        return redirect('login')->with('error', 'You need to login first.');
    }
}

public function showcart()
{
    $user = auth()->user();
    $cartItems = Cart::where('phone', $user->phone)->get();

    // Separate single products and configurations
    $singleProducts = $cartItems->filter(function ($item) {
        return $item->is_single_product; // Assuming there is a boolean flag to identify single products
    });

    $configurations = $cartItems->filter(function ($item) {
        return !$item->is_single_product; // Assuming configurations do not have this flag
    })->groupBy('configuration_id'); // Grouping by configuration ID to handle entire configurations

    $count = $cartItems->count();

    return view('User.showcart', compact('count', 'singleProducts', 'configurations'));
}
    public function deletecart($id){
         $data=cart::find($id);
         $data->delete();
         return redirect()->back()->with('message', 'Product removed successfully!');;
    }
    public function confirmorder(Request $request)
    {
        $user = auth()->user();
        $name = $user->name;
        $phone = $user->phone;
        $address = $user->address;

        // Retrieve all cart items for the user
        $cartItems = Cart::where('phone', $phone)->get();

        foreach ($cartItems as $cartItem) {
            $order = new Order;
            $order->product_name = $cartItem->product_title;
            $order->price = $cartItem->price;
            $order->quantity = $cartItem->quantity;
            $order->is_single_product = $cartItem->is_single_product;
            $order->name = $name;
            $order->phone = $phone;
            $order->address = $address;
            $order->status = 'not delivered'; 
            $order->save();

            // Remove the item from the cart
            $cartItem->delete();
        }

        
        return redirect()->route('invoice');

    }


    
   // In HomeController.php

   public function pconfigurator($step = 1)
{
    switch ($step) {
        case 1:
            $products = Product::where('category', 'Processor')->get();
            $category = 'Processor';
            break;
        case 2:
            $products = Product::where('category', 'Motherboard')->get();
            $category = 'Carte mère';
            break;
        case 3:
            $products = Product::where('category', 'Graphicalcard')->get();
            $category = 'carte graphique';
            break;
        case 4:
            $products = Product::where('category', 'Boitier')->get();
            $category = 'Boitier';
            break;
        case 5:
            $products = Product::where('category', 'ssd')->get();
            $category = 'ssd';
            break;
        case 6: // Final review step
            $userId = Auth::id();
            $selectedComponents = Configuration::where('user_id', $userId)->get();
            return view('User.pc_review', compact('selectedComponents'));
        default:
            $products = collect(); // empty collection
            $category = '';
            break;
    }
    $user = auth()->user();
            $count= cart::where('phone',$user->phone)->count();

    return view('User.pconfigurator', compact('products', 'step', 'category','count'));
}

public function saveConfig(Request $request)
{
    $step = $request->input('step');
    $product = $request->input('product');
    $userId = Auth::id();

    // Check if the user already has a configuration for this step
    $configuration = Configuration::where('user_id', $userId)
        ->where('component_type', $step)
        ->first();

    if ($configuration) {
        // Update existing configuration
        $configuration->product_id = $product['id'];
        $configuration->save();
    } else {
        // Create new configuration
        Configuration::create([
            'user_id' => $userId,
            'component_type' => $step,
            'product_id' => $product['id']
        ]);
    }

    return response()->json(['success' => true]);
}

public function submitConfiguration(Request $request)
{
    $userId = Auth::id();
    // Handle saving the configuration and clearing the user's configurations
    $this->storeConfigurationInCart($userId);

    Configuration::where('user_id', $userId)->delete();
    
    return redirect('/')->with('success', 'Configuration submitted successfully!');
}
private function storeConfigurationInCart($userId)
{
    $configurations = Configuration::with('product')->where('user_id', $userId)->get();
    $user = Auth::user();

    foreach ($configurations as $configuration) {
        $product = $configuration->product;
        if ($product) {
            $cart = new Cart;
            $cart->name = $user->name;
            $cart->phone = $user->phone;
            $cart->address = $user->address;
            $cart->product_title = $product->title;
            $cart->price = $product->price;
            $cart->is_single_product = false; 
            $cart->quantity = 1; // Assuming quantity as 1, update as needed
            $cart->save();
        }
    }
}

/////////////
public function invoice()
    {
        $user = auth()->user();
        $orders = Order::where('phone', $user->phone)->get();

        $singleProducts = $orders->filter(function ($order) {
            return $order->is_single_product;
        });

        $configurations = $orders->filter(function ($order) {
            return !$order->is_single_product;
        })->groupBy('configuration_id');

        return view('User.facture', compact('singleProducts', 'configurations', 'user'));
    }

    public function downloadInvoice()
    {
        $user = auth()->user();
        $orders = Order::where('phone', $user->phone)->get();

        $singleProducts = $orders->filter(function ($order) {
            return $order->is_single_product;
        });

        $configurations = $orders->filter(function ($order) {
            return !$order->is_single_product;
        })->groupBy('configuration_id');

        $pdf = PDF::loadView('User.facture', compact('singleProducts', 'configurations', 'user'));
        return $pdf->download('facture.pdf');
    }

}