<div class="row">
    <div class="col-sm-12">
        <form action="<?php  echo base_url('dashboard/update_stock/'.$this->uri->segment(3))  ?>" id="edit" enctype="multipart/form-data" method="post" >
            <div class="panel">
                <div class="panel-heading">Edit Stock
                    <div class="tools"><button type="submit" form="edit" class="btn btn-primary"><i class="mdi mdi-edit"></i> Update Stock</button></div>
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
                                        <input id="product_name" value="<?php  echo $stock['product_name'] ?>" name="product_name" type="text" required  max="255" placeholder="Product Name" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="form-group xs-mt-10">
                                    <label for="price" class="col-sm-2 control-label">Track this Item</label>
                                    <div class="col-sm-10">
                                        <select class="form-control input-sm" name="countable">
                                            <option value="1" <?php echo $stock['countable'] == "1" ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?php echo $stock['countable'] == "0" ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                </div>
                                <!--
					<div class="form-group xs-mt-10">
                      <label for="price" class="col-sm-2 control-label">Manufacturer Date</label>
                      <div class="col-sm-10">
                        <input id="date_available" type="text" value="<?php  echo $stock['manufacturer_date'] ?>" name="manufacturer_date" data-min-view="2" data-date-format="yyyy-mm-dd"  placeholder="Manufacturer Date" class="date form-control input-sm">
                      </div>
                    </div>

					<div class="form-group xs-mt-10">
                      <label for="price" class="col-sm-2 control-label">Expired Date</label>
                      <div class="col-sm-10">
                        <input id="date_available" type="text" value="<?php  echo $stock['expired_date'] ?>" name="expired_date" data-min-view="2" data-date-format="yyyy-mm-dd"  placeholder="Expired Date" class="date form-control input-sm">
                      </div>
                    </div>
                      -->

                                <div class="form-group xs-mt-10">
                                    <label for="price" class="col-sm-2 control-label">Quantity</label>
                                    <div class="col-sm-10">
                                        <input id="price" type="number" required name="quantity" value="<?php echo $stock['quantity'] ?>"  placeholder="Quantity" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="form-group xs-mt-10">
                                    <label for="price" class="col-sm-2 control-label">Selling Price</label>
                                    <div class="col-sm-10">
                                        <input id="price" type="number" required name="price" value="<?php echo $stock['price'] ?>"  placeholder="Selling Price" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="form-group xs-mt-10">
                                    <label for="price" class="col-sm-2 control-label">Cost Price</label>
                                    <div class="col-sm-10">
                                        <input id="price" type="number" required name="cost_price" value="<?php echo $stock['cost_price'] ?>" placeholder="Cost price" class="form-control input-sm">
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
