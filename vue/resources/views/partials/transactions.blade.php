<?php

use App\Order;
$user = Auth::user(); // Assuming you are using Laravel and have a logged-in user

if ($user->role==1) {
    // Admin user sees latest 10 orders from all users
    $orders = Order::select('orders.*', 'users.name as user_name')
                   ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                   ->where('orders.is_deleted', 0)
                   ->where('orders.amount', '>', 0)
                   ->orderBy('orders.created_at', 'desc')
                   ->take(10)
                   ->get();
} else {
    // Regular user sees only their own orders with user names
    $orders = Order::select('orders.*', 'users.name as user_name')
                   ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                   ->where('orders.user_id', $user->id)
                   ->where('orders.is_deleted', 0)
                   ->where('orders.amount', '>', 0)
                   ->orderBy('orders.created_at', 'desc')
                   ->take(10)
                   ->get();
}
?>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h3> Recent Transactions </h3>
                <div class="table-responsive">
                    <table class="table mb-0 table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Amount</th>
                                <th>Paid On</th>  
                                <th>Paid By</th> 
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><a href="{{ url('/order',$order->id) }}"><?php echo htmlspecialchars($order->id); ?></a></td>
                                <td>$ <?php echo htmlspecialchars($order->amount); ?></td>
                                <td><?php echo htmlspecialchars($order->created_at); ?></td>
                                <td><?php echo htmlspecialchars($order->user_name); ?></td>
                                <td>
    							    <div class="d-flex">
    									<span class="text-gray font-weight-semibold">
    									    @if($order->status==2)
            									<span class=""> <span class="badge badge-pill badge-warning">Assigned</span></span>
            								@elseif($order->status==3)
            									<span class=""> <span class="badge badge-pill badge-primary">Editing</span></span>
            								@elseif($order->status==4)
            									<span class=""> <span class="badge badge-pill badge-secondary">Revision</span></span>
            								@elseif($order->status==5)
            									<span class=""> <span class="badge badge-pill badge-success">Completed</span></span>
            								@elseif($order->status==6)
            									<span class=""> <span class="badge badge-pill badge-success">Approved</span></span>
            								@else
            									<span class=""> <span class="badge badge-pill badge-danger">Cancelled</span></span>
    									    @endif
    									</span>
    							    </div>
								</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>