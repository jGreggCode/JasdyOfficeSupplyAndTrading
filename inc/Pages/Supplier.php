<div class="tab-pane fade" id="v-pills-vendor" role="tabpanel" aria-labelledby="v-pills-vendor-tab">
    <div class="card card-outline-secondary my-4">
        <div class="card-header">Supplier Details</div>
        <div class="card-body">
            <!-- Div to show the ajax message from validations/db submission -->
            <div id="vendorDetailsMessage"></div>
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="vendorDetailsVendorFullName">Supplier Name<span class="requiredIcon">*</span></label>
                        <input type="text" class="form-control" id="vendorDetailsVendorFullName" name="vendorDetailsVendorFullName" placeholder="">
                    </div>
                    <!-- <div class="form-group col-md-2">
                        <label for="vendorDetailsStatus">Status</label>
                        <select id="vendorDetailsStatus" name="vendorDetailsStatus" class="form-control chosenSelect">
                        <?php //include('inc/statusList.html'); ?>
                        </select>
                    </div> -->
                    <div class="form-group col-md-3">
                        <label for="vendorDetailsVendorID">Supplier ID <small>Auto Generated</small></label>
                        <input readonly type="text" class="form-control invTooltip" id="vendorDetailsVendorID" name="vendorDetailsVendorID" title="This will be auto-generated when you add a new vendor" autocomplete="off">
                        <div id="vendorDetailsVendorIDSuggestionsDiv" class="customListDivWidth"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="vendorDetailsVendorMobile">Primary Phone No.<span class="requiredIcon">*</span></label>
                        <input type="text" class="form-control invTooltip" id="vendorDetailsVendorMobile" name="vendorDetailsVendorMobile" title="Format: 09xxxxxxxxx">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="vendorDetailsVendorPhone2">Secondary Phone No.</label>
                        <input type="text" class="form-control invTooltip" id="vendorDetailsVendorPhone2" name="vendorDetailsVendorPhone2" title="Format: 09xxxxxxxxx">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="vendorDetailsVendorEmail">Email</label>
                        <input type="email" class="form-control" id="vendorDetailsVendorEmail" name="vendorDetailsVendorEmail">
                    </div>
                </div>
                <div class="form-group">
                    <label for="vendorDetailsVendorAddress">Permanent Address<span class="requiredIcon">*</span></label>
                    <input type="text" class="form-control" id="vendorDetailsVendorAddress" name="vendorDetailsVendorAddress">
                </div>
                <div class="form-group">
                    <label for="vendorDetailsVendorAddress2">Temporary Address</label>
                    <input type="text" class="form-control" id="vendorDetailsVendorAddress2" name="vendorDetailsVendorAddress2">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="vendorDetailsVendorCity">City</label>
                        <input type="text" class="form-control" id="vendorDetailsVendorCity" name="vendorDetailsVendorCity">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="vendorDetailsVendorDistrict">District</label>
                        <select id="vendorDetailsVendorDistrict" name="vendorDetailsVendorDistrict" class="form-control chosenSelect">
                        <?php include('inc/districtList.html'); ?>
                        </select>
                    </div>
                </div>
                <button type="button" id="addVendor" name="addVendor" class="btn btn-success">Add Supplier</button>
                <button type="reset" class="btn">Clear</button>
            </form>
        </div>
    </div>
</div>