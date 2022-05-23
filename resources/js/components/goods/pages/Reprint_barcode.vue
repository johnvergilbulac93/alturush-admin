<template>
  <div class="container">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- /.col -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <Breadcrumb>
                <BreadcrumbItem to="/">
                  <Icon type="md-home" size="20" color="orange" /> Dashboard
                </BreadcrumbItem>
                <BreadcrumbItem to="/item">
                  <Icon type="md-basket" size="20" color="orange" /> Item
                  Masterfile</BreadcrumbItem
                >
                <BreadcrumbItem to="/business_rule">
                  <Icon type="md-settings" size="20" color="orange" /> Business
                  Rules Set-Up</BreadcrumbItem
                >
                <BreadcrumbItem to="/picker_time">
                  <Icon type="md-settings" size="20" color="orange" /> Picker
                  Set-up Time
                </BreadcrumbItem>
                <BreadcrumbItem to="/reprint_barcode">
                  <Icon type="md-settings" size="20" color="orange" /> Allowed Reprint Barcode</BreadcrumbItem
                >
              </Breadcrumb>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>

    <hr class="orange" />
  </div>
</template>
