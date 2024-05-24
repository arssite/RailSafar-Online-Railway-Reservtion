<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $trains = $conn->query("SELECT *,Concat(code,' - ',`name`) as train FROM `train_list` where id in (SELECT train_id FROM `schedule_list` where delete_flag = 0 and id in (SELECT schedule_id FROM `reservation_list` where id in ({$_GET['id']}) ) )");
    $res = $trains->fetch_all(MYSQLI_ASSOC);
    $train_fcf_arr = array_column($res,'first_class_capacity','id');
    $train_ef_arr = array_column($res,'economy_capacity','id');
    $train_arr = array_column($res,'train','id');
    $qry = $conn->query("SELECT r.*,s.code as sched_code,s.train_id from `reservation_list` r inner join `schedule_list` s on r.schedule_id = s.id where r.id in ({$_GET['id']}) ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_all(MYSQLI_ASSOC);
    }else{
        echo '<script> alert("Unkown Reservation ID(s).");location.replace("./?page=schedules") </script>';
    }
} else{
    echo '<script> alert("Reservation ID(s) is required to view this page.");location.replace("./?page=schedules") </script>';
}
$train_group = ['','First Class','Economy'];
?>
<style>
    #uni_modal .modal-footer{
        display:none;
    }
    
    #assignatory{
        display:none !important;
    }
</style>
<div class="container-fluid">
    <div id="outprint" class="list-group">
        <style>
            .logo {
                width: 50px;
                height: 50px;
                object-fit: scale-down;
                object-position: center center;
                left: 17.33%;
                position: relative;
                top: -0.33em;
                border: 1px solid black;
                border-radius: 50% 50%;
            }
            @media screen{
                .logo{
                    left: 10.33%;
                }
            }
            .tickets{
                border-bottom: 3px dashed
            }
        </style>
        <?php foreach($res as $row): ?>
        <div class="list-group-item tickets py-5">
            <div class="row align-items-center">
                <div class="col-1 text-center">
                </div>
                <div class="col-12 text-center">
                    <img src="<?= validate_image($_settings->info('logo')) ?>" alt="logo" class="logo float-left">
                    <h3 class="m-0 text-center"><?= $_settings->info('name') ?></h3>
                    <h5 class="m-0 text-center">Travel Ticket</h5>
                </div>
            </div>
            <hr>
            <div class="clear-fix my-5"></div>
            <div class="row">
                <div class="col-auto pr-2"><b>Schedule Code:</b></div>
                <div class="col-auto flex-grow-1 border-bottom border-dark"><b><?= $row['sched_code'] ?></b></div>
                <div class="col-auto pl-4 pr-2"><b>Train:</b></div>
                <div class="col-auto flex-grow-1 border-bottom border-dark"><b><?= isset($train_arr[$row['train_id']]) ? $train_arr[$row['train_id']] : "N/A" ?></b></div>
            </div>
            <div class="row">
                <div class="col-auto pr-2"><b>Schedule:</b></div>
                <div class="col-auto flex-grow-1 border-bottom border-dark"><b><?= date("M d, Y h:i A", strtotime($row['schedule'])) ?></b></div>
                <div class="col-auto pl-4 pr-2"><b>Seat #:</b></div>
                <div class="col-auto flex-grow-1 border-bottom border-dark"><b><?= $row['seat_num'] ?></b></div>
                <div class="col-auto pl-4 pr-2"><b>Group:</b></div>
                <div class="col-auto flex-grow-1 border-bottom border-dark"><b><?= $train_group[$row['seat_type']] ?></b></div>
            </div>
            <div class="row">
                <div class="col-auto pr-2"><b>Passenger Name:</b></div>
                <div class="col-auto flex-grow-1 border-bottom border-dark"><b><?= strtoupper($row['lastname'].', '.$row['firstname'].' '.$row['middlename']) ?></b></div>
            </div>
            <div class="clear-fix my-5"></div>
            <div class="d-flex justify-content-end" id="assignatory">
                <div class="col-md-4">
                    <div class="border-bottom text-center border-dark"><?= $_settings->userdata('fistname').' '.$_settings->userdata('middlename').' '.$_settings->userdata('lastname') ?></div>
                    <div class="text-center">Printed By</div>
                    <div class="text-center"><?= date("Y-m-d H:i") ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="clear-fix my-2"></div>
    <div class="text-right">
        <button class="btn btn-sm btn-flat btn-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
        <button class="btn btn-sm btn-flat btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>

<script>
   
   $(function(){
    $('#print').click(function(){
        var _h = $("head").clone()
        var _p = $("#outprint").clone();
        var el = $("<div>");
            el.append(_h)
            el.append(_p)
        start_loader()
        var nw = window.open('','_blank','width=1000,height=720,top=100,left=100')
            nw.document.write(el.html())
            nw.document.close()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader();
                }, 500);
            }, 750);

    })
   })
    
</script>