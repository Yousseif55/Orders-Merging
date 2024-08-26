<?php

/*  

Plugin Name: Orders Merging

Description: Plugin Allow to merge unlimited numbers of orders to the most recent one with adding all products items, fees if is existed, all of this done by bulk action! *UPDATED VERSION* : Merging extra fields, HPOS Compatibility .

Author: Yousseif Ahmed 

Version: 1.1.1

*/


// Add Merge Orders in bulk actions 
function merging_bulk_action($actions)
{
  $actions['merge_orders'] = 'Merge Orders';
  return $actions;
}

// Handle Merge Orders actions
function handle_custom_bulk_action($redirect_to, $action, $post_ids)
{
  if ($action === 'merge_orders') {
    $merged_order_id = $post_ids[0]; // The most recent order ID
    $merged_order = wc_get_order($merged_order_id);

  // Loop for get order ids // Condition for avoid single merging 

    foreach ($post_ids as $order_id) {

   // Condition for avoid single merging 

      if ($order_id !== $merged_order_id) {
        $order_to_merge = wc_get_order($order_id);

        // Merge products
   foreach ($order_to_merge->get_items() as $item) {
    $product_id = $item->get_product_id();
    $quantity = $item->get_quantity();

    // Initialize a flag to track whether the product is found
    $product_found = false;

    // Iterate through items in the merged order
    foreach ($merged_order->get_items() as $merged_item) {
        if ($merged_item->get_product_id() == $product_id) {
            $existing_quantity = $merged_item->get_quantity();
            $merged_item->set_quantity($existing_quantity + $quantity , true);
			$merged_item->set_subtotal(($existing_quantity + $quantity) * $merged_item->get_product()->get_price());
			$merged_item->set_total(($existing_quantity + $quantity) * $merged_item->get_product()->get_price());
            $product_found = true;
            break;
        }
    }

    if (!$product_found) {
        $merged_order->add_product($item->get_product(), $quantity);
    }
	    
    
  
}

        // Merge Fees
        $fees = (array) $order_to_merge->get_items('fee');

        foreach ($fees as $fee) {
          $merged_order->add_item($fee);
        }

         
      // Merge Items meta   
        $items_to_merge = $order_to_merge->get_items('shipping'); // Getting Shipping From order to merge
        $merged_items = $merged_order->get_items('shipping'); // Getting Shipping From merged order

        foreach ($items_to_merge as $item_id => $item) {

          // Get meta data for the order to merge
          $meta_data = $item->get_meta('Items', true);

          foreach ($merged_items as $item_id_merged => $item_merged) {
            $meta_data_merged = $item_merged->get_meta('Items', true);

            // Combine meta data with a creative separator
            $combined_meta_data = $meta_data_merged . ' &#10133; ' . $meta_data;

            // Update meta data for the merged order
            $item_merged->update_meta_data('Items', $combined_meta_data, true);
          }
        }

        // Add order note that emphasize merging
        $merged_order->add_order_note('Merged from Order #' . $order_id);

        $order_to_merge->add_order_note('Merged to Order #' . $merged_order_id);

        $order_to_merge->save();

        $merged_order->calculate_totals(); // Recalculate totals
    

		set_transient( 'successmerging', true );  
        $orders_to_delete[] = $order_id; // Delete order to merge

      }

    }

    // Delete the old orders outside the loop
    foreach ($orders_to_delete as $order_id_to_delete) {
      wp_trash_post($order_id_to_delete, true);
    }
    // Save changes
    $merged_order->save();

    // Redirect to the order list page after merging
    $redirect_to = admin_url('admin.php?page=wc-orders');

    return $redirect_to;
  }

  return $redirect_to;
}


function ordermerging() {

  if ( get_transient( 'successmerging' ) ) {

      $message = 'Orders merged successfully.';
            echo '<div class="notice notice-success is-dismissible"><p>' . $message . '</p></div>';

    delete_transient( 'successmerging' );

  }

}

