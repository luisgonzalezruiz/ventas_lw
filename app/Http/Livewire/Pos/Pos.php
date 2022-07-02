<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Denomination;
use App\Models\Product;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Pos extends Component
{
    public $total, $itemsQuantity, $efectivo, $change;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change=0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

    }

    public function render()
    {
        $denominations = Denomination::orderBy('value','desc')->get();
        // asi recuperamos los datos del carrito, esto maneja sesiones de manera interna
        $cart = Cart::getContent()->sortBy('name');

        return view('livewire.pos.pos',compact('denominations','cart'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function ACash($value)
    {
        $this->efectivo += ($value==0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scanCode' => 'scanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];

    public function scanCode($barcode, $cant = 1)
    {

        //dd($barcode);

        $product = Product::where('barcode',$barcode)->first();
        if( $product == null ){
            $this->emit('scan-notfount','El producto no esta registrado');
        }else{

            if($this->InCart($product->id)){
                $this->increaseQty($product->id);
                return;
            }
            if($product->stock < 1){
                $this->emit('no-stock','Stock insuficiente :/');
                return;
            }

            Cart::add($product->id,
                      $product->name,
                      $product->price,
                      $cant,
                      $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok','Producto agregado');
        }
    }

    public function InCart($productId)
    {
        // de esta forma verificamos si el producto ya existe en el carrito
        $exist = Cart::get($productId);
        if ($exist)
            return true;
        else
            return false;

    }

    public function increaseQty($productId, $cant = 1)
    {
        $title='';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title='Cantidad actualizada';
        else
            $title='Producto agregdo';

        if ($exist){
            if( $product->stock < ( $cant + $exist->quntity) ){
                $this->emit('no-stock','Stock insuficiente :/');
                return;
            }
        }

        Cart::add($product->id,
                 $product->name,
                 $product->price,
                 $cant,
                 $product->image);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);

    }

    public function updateQty($productId, $cant = 1)
    {
        $title='';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist){
            $title='Cantidad actualizada';
        }else{
            $title='Producto agregdo';
        }

        if ($exist){
            if( $product->stock < $cant ){
                $this->emit('no-stock','Stock insuficiente :/');
                return;
            }
        }

        $this->removeItem($productId);

        if($cant > 0){
            Cart::add($product->id,
                      $product->name,
                      $product->price,
                      $cant,
                      $product->image);

            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }else{
            $this->emit('no-stock','Cantidad debe ser mayor a cero');
            return;
        }

    }

    public function removeItem($productId)
    {
        Cart::remove($productId);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
    }

    public function decreaseQty($productId)
    {
        //recuperamos el registro del producto del carrito
        $item = Cart::get($productId);

        //borramos el item del carrito
        Cart::remove($productId);

        // ajustamos la cantidad en menos 1
        $newQty = ( $item->quantity ) - 1;

        // si aun hay valor mayor a cero volvemos a cargar el producto con el nuevo valor
        if($newQty > 0){
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->image);
        }

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Cantidad actualizada');

    }

    public function clearCart()
    {

        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito eliminado');

    }

    public function saveSale()
    {
        if($this->total <= 0){
            $this->emit('sale-error','Agrega productos a la venta');
            return;
        }
        if($this->efectivo <= 0){
            $this->emit('sale-error','Ingrese el efectivo');
            return;
        }
        if($this->total > $this->efectivo){
            $this->emit('sale-error','Efectivo debe ser mayor o igual al total');
            return;
        }

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'user_id' => Auth()->user()->id
            ]);

            if ($sale){
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'price' => $item->price,
                        'sale_id' => $sale->id
                    ]);

                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo=0;
            $this->change=0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->emit('sale-ok','Venta registrada!!!');
            $this->emit('print-ticket',$sale->id);

        } catch (\Exception $exp) {
            DB::rollBack();
            $this->emit('sale-error', $exp->getMessage());
        }

    }

    public function printTicket($sale)
    {
        // esto va ser capturado por el servidor de impresiones que
        // lo hacemos en C#
        return Redirect::to("print://$sale->id");
    }

}
