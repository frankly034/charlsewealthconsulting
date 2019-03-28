<?php

namespace App;



class Cart
{
    public $items = null ;
    public $totalQty = 0 ;
    public $totalPrice = 0 ;

    public function __construct($oldCart = null){
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id){
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if($this->items){
            if(array_key_exists($id, $this->items)){ 
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->price;
    }

    public function reduceByOne($id){
        $quantity = $this->items[$id]['qty'];
        $quantity--;
       $itemPrice = $this->items[$id]['price'];
       $itemPrice  -= $this->items[$id]['item']['price'];
       if($this->totalQty >= 0){
            $this->totalQty--;
       }else{
           $this->totalQty = 0;
       }
        $this->totalPrice -= $this->items[$id]['item']['price'];
        if($this->items[$id]['qty'] <= 0){
            unset($this->items[$id]);
        }
    }

    public function removeItem($id){
        if(array_key_exists($id, $this->items)){
        $itemsQty = $this->items[$id]['qty'];
        $itemsPrice = $this->items[$id]['price']; 

        $this->totalQty -= $itemsQty;
        $this->totalPrice -= $itemsPrice;
        unset($this->items[$id]);
        }
    
    }
}
