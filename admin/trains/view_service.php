<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `service_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none !important;
    }
</style>
<div class="container-fluid">
    <dl>
        <dt class="text-muted">Service</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($service) ? $service : '' ?></dd>
        <dt class="text-muted">Description</dt>
        <dd class='pl-4'>
            <p class=""><small><?= isset($description) ? html_entity_decode($description) : '' ?></small></p>
        </dd>
        <dt class="text-muted">Fee</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($cost) ? number_format($cost,2) : '0.00' ?></dd>
    </dl>
    <div class="col-12 text-right">
        <button class="btn btn-flat btn-sm btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>