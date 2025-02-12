<div class="tab-pane fade" id="v-pills-purchase" role="tabpanel" aria-labelledby="v-pills-purchase-tab">
    <div class="card card-outline-secondary my-4">
        <div class="card-header">Restock Details</div>
        <div class="card-body">
            <div id="purchaseDetailsMessage"></div>
            <form>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="purchaseDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
                        <input type="text" class="form-control" id="purchaseDetailsItemNumber" name="purchaseDetailsItemNumber" autocomplete="off">
                        <div id="purchaseDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="purchaseDetailsPurchaseDate">Date Delivered<span class="requiredIcon">*</span></label>
                        <input type="date" class="form-control" id="purchaseDetailsPurchaseDate" name="purchaseDetailsPurchaseDate" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsPurchaseID">Purchase ID</label>
                        <input readonly type="text" class="form-control invTooltip" id="purchaseDetailsPurchaseID" name="purchaseDetailsPurchaseID" title="This will be auto-generated when you add a new record" autocomplete="off">
                        <div id="purchaseDetailsPurchaseIDSuggestionsDiv" class="customListDivWidth"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="purchaseDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
                        <input type="text" class="form-control invTooltip" id="purchaseDetailsItemName" name="purchaseDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsCurrentStock">Current Stock</label>
                        <input type="text" class="form-control" id="purchaseDetailsCurrentStock" name="purchaseDetailsCurrentStock" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="purchaseDetailsVendorName">Vendor Name<span class="requiredIcon">*</span></label>
                        <select id="purchaseDetailsVendorName" name="purchaseDetailsVendorName" class="form-control chosenSelect">
                        <?php 
                            require('model/vendor/getVendorNames.php');
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
                        <input type="number" class="form-control" id="purchaseDetailsQuantity" name="purchaseDetailsQuantity" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsUnitPrice">Costing<span class="requiredIcon">*</span></label>
                        <input type="number" class="form-control" id="purchaseDetailsUnitPrice" name="purchaseDetailsUnitPrice" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsTotal">Total Cost</label>
                        <input type="text" class="form-control" id="purchaseDetailsTotal" name="purchaseDetailsTotal" readonly>
                    </div>
                </div>
                <button type="button" id="addPurchase" class="btn btn-success">Restock Item</button>
                <!-- <button type="button" id="updatePurchaseDetailsButton" class="btn btn-primary">Update</button> -->
                <button type="reset" class="btn">Clear</button>
            </form>
        </div>
    </div>
</div>