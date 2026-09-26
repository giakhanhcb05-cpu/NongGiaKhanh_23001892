<?php

class CartItem 
{
    public $name;
    public $price;
    public $quantity;

    public function __construct($name, $price, $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getTotal()
    {
        return $this->quantity * $this->price;
    }
}

class ShoppingCart
{
    public $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function addItem($item)
    {
        if ($item->price <= 0) {
            echo "Gia san pham phai lon hon 0.<br>";
            return;
        }

        if ($item->quantity <= 0) {
            echo "So luong san pham phai lon hon 0.<br>";
            return;
        }

        $this->items[] = $item;
    }

    public function removeItem($name)
    {
        foreach ($this->items as $key => $item) {
            if ($item->name == $name) {
                unset($this->items[$key]);

                
                $this->items = array_values($this->items);
                echo "Da xoa san pham: " . $name . "<br><br>";
                return;
            }
        }

        echo "Khong tim thay san pham: " . $name . "<br><br>";
    }

    public function calculateTotal()
    {
        if (count($this->items) == 0) {
            return 0;
        }

        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    public function displayCart()
    {
        if (count($this->items) == 0) {
            echo "Gio hang trong.<br>";
            return;
        }

        foreach ($this->items as $item) {
            echo "Ten san pham: " . $item->name . "<br>";
            echo "Don gia: " . $item->price . "<br>";
            echo "So luong: " . $item->quantity . "<br>";
            echo "Thanh tien: " . $item->getTotal() . "<br><br>";
        }

        echo "Tong tien: " . $this->calculateTotal() . "<br>";
    }
}



$cart = new ShoppingCart();

$item1 = new CartItem("Laptop", 1500, 1);
$item2 = new CartItem("Chuot", 300, 2);
$item3 = new CartItem("Ban phim", 500, 1);
$item4 = new CartItem("Tai nghe", 700, 2);

$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);

echo "<h2>Gio hang ban dau</h2>";

$cart->displayCart();

echo "<br>";

$cart->removeItem("Chuot");

echo "<h2>Gio hang sau khi xoa</h2>";

$cart->displayCart();

?>