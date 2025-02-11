<!-- Modal for Order Details -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-sm" id="orderModalDialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close" style="color:white!important;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Order Details -->
                <h3>Customer Details</h3>
                <p id="orderDetails"></p><br>
                <h3>Order Details</h3>
                <p id="orderTotalPrice"></p><br>
                <p id="orderStatus"></p><br>
                <p id="orderDate"></p>

                <div id="orderProducts" class="mt-3">
                    <!-- Product details will be populated here dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
