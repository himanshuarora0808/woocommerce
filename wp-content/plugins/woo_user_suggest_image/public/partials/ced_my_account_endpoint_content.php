
<?php 
//  $order = wc_get_order( $order_id );
//  $items = $order->get_items();
//  print_r($order); 
// global $order_id;
// $order = wc_get_order($order_id);
// print_r($order);

// $args = array(
//     'post_type' => 'shop_order',
//    'posts_per_page' => '-1'
//   );
//   $my_query = new WP_Query($args);
  
//   $orders = $my_query->posts;
//   echo "</pre>";
//   print_r($orders);
//   echo "<pre>";
  
// $query = new WC_Order_Query( array(
//     'limit' => 10,
//     'orderby' => 'date',
//     'order' => 'DESC',
//     'return' => 'ids',
// ) );
// $orders = $query->get_orders();
// print_r($orders);


$cuid = get_current_user_id();

// echo '<pre>';
// echo( $cuid);

// $query = new WC_Order_Query();
// // $query->set( 'customer', 'woocommerce@woocommerce.com' );
// $orders = $query->get_orders();
// echo '<pre>';
// print_r($orders);

// $args = array(
//     'exclude' => array( $order->get_id() ),
// );
// $orders = wc_get_orders( $args );
// print_r($orders);
// global $woocommerce;
// global $order;
// $order = new WC_Order($order_id);
// $order = wc_get_order( $order_id );
// print_r($order);



// if (isset ($order_id)) {
// $order = new WC_Order($order_id);
// $items = $order->get_items();
// foreach ($items as $item) {
// $product_id = $item['product_id'];
// echo $product_id;
// if ($product_id == your product id) {
// //do something
// echo 'sadfjhaf';
// } else {
//     echo 'asfkdgsaldif';
// //do something
// }


// }
// }
global $woocommerce;
global $order;
$order = wc_get_order( $order_id );
print_r($order);

// Get the order ID
$order_id = $order->get_id();
$user_id = $order->get_user_id();

// Get the custumer ID
$order_id = $order->get_user_id();
?>
<h1>Hello mr this is </h1>