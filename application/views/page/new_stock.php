<div class="row">
    <div class="col-sm-12">
        <form action="<?php  echo base_url('dashboard/save_new_stock')  ?>" enctype="multipart/form-data" method="post" >
            <div class="panel">
                <div class="panel-heading">Add New Stock
                    <div class="tools"><button type="submit" class="btn btn-lg btn-primary"><i class="mdi mdi-save"></i> Save Product</button></div>
                </div>
                <div class="tab-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Data</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane active cont">
                            <div class="form-horizontal">

                                <div class="form-group xs-mt-10">
                                    <label for="product_name" class="col-sm-2 control-label">Product Name</label>
                                    <div class="col-sm-10">
                                        <input id="product_name" name="product_name" type="text" required  max="255" placeholder="Product Name" class="form-control input-sm">
                                    </div>
                                </div>

                                <input id="date_available" type="hidden" value="<?php echo date('Y-m-d'); ?>" name="manufacturer_date" data-min-view="2" data-date-format="yyyy-mm-dd"  placeholder="Manufacturer Date" class="date form-control input-sm">

                                <input id="date_available" type="hidden" value="<?php echo date('Y-m-d'); ?>" name="expired_date" data-min-view="2" data-date-format="yyyy-mm-dd"  placeholder="Expired Date" class="date form-control input-sm">


                                <div class="form-group xs-mt-10">
                                    <label for="price" class="col-sm-2 control-label">Track this Item</label>
                                    <div class="col-sm-10">
                                        <select class="form-control input-sm" name="countable">
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group xs-mt-10">
                                    <label for="price" class="col-sm-2 control-label">Quantity</label>
                                    <div class="col-sm-10">
                                        <input id="price" type="number" value="0" required name="quantity"  placeholder="Quantity" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="form-group xs-mt-10">
                                    <label for="price" class="col-sm-2 control-label">Selling Price</label>
                                    <div class="col-sm-10">
                                        <input id="price" type="number" required name="price"  placeholder="Selling Price" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="form-group xs-mt-10">
                                    <label for="price" class="col-sm-2 control-label">Cost Price</label>
                                    <div class="col-sm-10">
                                        <input id="price" type="number" required name="cost_price"  placeholder="Cost Price" class="form-control input-sm">
                                    </div>
                                </div>

                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
