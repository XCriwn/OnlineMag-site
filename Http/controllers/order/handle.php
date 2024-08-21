<?php

//TODO here we will put administration of orders

/* TODO we need to have here:
    -   destroy the current order
    -   take all items from the order and put them in a new table specific for handling completed orders
    -   put PENDING to the status of the order
    -   admins can update the status of the order and see the details
    -   in Profile page i want a button to see submitted orders and their status
    ------
    -   i will also have to put a new column in order to determine whether the order is active or completed
    -   the column will take values: INCOMPLETE, PENDING, CANCELLED, COMPLETED
    -   we have to rethink the order display in cart to show if the order is incomplete and to create a new order if it is not incomplete
    -

*/
$db = \core\App::resolve(\database\Database::class);
$order_id = $_POST['order_id'];

//TODO i dont need products, i just have to update the status of the order

$db->query("update `order` set status = 'PENDING' where id = :id AND user_id = :user_id", [
    //TODO uncomment this when done
    'id' => $order_id,
    'user_id' => getCurrentUserId()
]);

redirect('/my_orders');
