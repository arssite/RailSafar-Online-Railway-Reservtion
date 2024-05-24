<?php 
$date = isset($_GET['date']) ? date("Y-m-d", strtotime($_GET['date'])) : "";
$time = isset($_GET['time']) ? date("H:i", strtotime($_GET['time'])) : "";
?>
<div class="content py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-outline card-primary rounded-0 shadow">
                <div class="card-body">
                    
                    <div class="callout border-primary rounded-0 shadow">
                        <fieldset>
                            <legend class="text-muted">Find Schedule</legend>
                            <form action="" id="filter-schedule">
                                <div class="row align-items-end">
                                    <div class="col-md-3 col-sm-4">
                                        <label for="date" class="control-label">Desired Date</label>
                                        <input type="date" name="date" id="date" class="form-control form-control-sm rounded-0" value="<?= $date ?>" required>
                                    </div>
                                    <div class="col-md-3 col-sm-4">
                                        <label for="time" class="control-label">Desired Time</label>
                                        <input type="time" name="time" id="time" class="form-control form-control-sm rounded-0" value="<?= $time ?>" required>
                                    </div>
                                    <div class="col-md-3 col-sm-4">
                                        <button class="btn btn-flat btn-primary"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                    <hr>
                    <table class="table table-hover table-striped table-bordered">
                        <colgroup>
                            <col width="15%">
                            <col width="15%">
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gradient-primary text-light">
                                <th>Code</th>
                                <th>Schedule</th>
                                <th>Route</th>
                                <th>Train</th>
                                <th>Slot/Rate</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                // Schedule List Dynamic where clause
                                $swhere = "";
                                if(!empty($date) && !empty($time)){
                                    $swhere = " and ((`type` = 1 and time(time_schedule) BETWEEN '".(date('H:i',strtotime($date." ".$time." -2 hours")))."' and '".(date('H:i',strtotime($date." ".$time." +2 hours")))."' ) or (`type` = 2 and date(date_schedule) = '{$date}' and time(time_schedule) BETWEEN '".(date('H:i',strtotime($date." ".$time." -2 hours")))."' and '".(date('H:i',strtotime($date." ".$time." +2 hours")))."' ))" ;
                                }
                                $i = 1;
                                $reservations = $conn->query("SELECT * FROM `reservation_list` where schedule_id in (SELECT id FROM `schedule_list` where delete_flag = 0 {$swhere}) ");
                                while($row = $reservations->fetch_assoc()){
                                    if(!isset($reserve[$row['schedule_id']][$row['seat_type']])) $reserve[$row['schedule_id']][$row['seat_type']] = 0;
                                    $reserve[$row['schedule_id']][$row['seat_type']] += 1;
                                }
                                $trains = $conn->query("SELECT *,Concat(code,' - ',`name`) as train FROM `train_list` where id in (SELECT train_id FROM `schedule_list` where delete_flag = 0 {$swhere})");
                                $res = $trains->fetch_all(MYSQLI_ASSOC);
                                $train_fcf_arr = array_column($res,'first_class_capacity','id');
                                $train_ef_arr = array_column($res,'economy_capacity','id');
                                $train_arr = array_column($res,'train','id');
                                $qry = $conn->query("SELECT * from `schedule_list` where delete_flag = 0 {$swhere} order by unix_timestamp(`date_created`) asc ");
                                while($row = $qry->fetch_assoc()):
                                    $fc_capacity = isset($train_fcf_arr[$row['train_id']]) ? $train_fcf_arr[$row['train_id']] : 0;
                                    $e_capacity = isset($train_ef_arr[$row['train_id']]) ? $train_ef_arr[$row['train_id']] : 0;
                                    $fc_reserve = isset($reserve[$row['id']][1]) ? $reserve[$row['id']][1] : 0;
                                    $e_reserve = isset($reserve[$row['id']][2]) ? $reserve[$row['id']][2] : 0;
                                    $fc_slot = $fc_capacity - $fc_reserve;
                                    $e_slot = $e_capacity - $e_reserve;
                            ?>
                                <tr>
                                    <td class="text-center px-1"><?= $row['code'] ?></td>
                                    <td class="px-0">
                                        <?php if($row['type'] == 1): ?>
                                        <div class="px-1 border-bottom"><span class="text-muted fa fa-calendar"></span> Everyday</div>
                                        <?php else: ?>
                                        <div class="px-1 border-bottom"><span class="text-muted fa fa-calendar-day"></span> <?= date("M d, Y",strtotime($row['date_schedule'])) ?></div>
                                        <?php endif; ?>
                                        <div class="px-1"><span class="text-muted fa fa-clock"></span> <?= date("h:i A",strtotime($row['time_schedule'])) ?></div>
                                    </td>
                                    <td class="px-0">
                                        <div class="px-1 border-bottom"><span class="text-muted">From:</span> <b><?= $row['route_from'] ?></b></div>
                                        <div class="px-1"><span class="text-muted">To:</span> <b><?= $row['route_to'] ?></b></div>
                                    </td>
                                    <td class="px-1"><?php echo isset($train_arr[$row['train_id']]) ? $train_arr[$row['train_id']] : "N/A" ?></td>
                                    <td class="px-0">
                                        <div class="px-1 border-bottom"><span class="text-muted">First Class:</span> <span class="text-muted fa fa-user"></span> <b><?= $row['type'] == 1 ? "<i class='fa fa-question' title='Slot depends to the date you desire.'></i>" : number_format($fc_slot) ?></b> <span class="text-muted ml-2 fa fa-tag"></span> <b><?= rtrim(number_format($row['first_class_fare'],2),'.') ?></b></div>
                                        <div class="px-1"><span class="text-muted">Economy:</span> <span class="text-muted fa fa-user"></span> <b><?= $row['type'] == 1 ? "<i class='fa fa-question' title='Slot depends to the date you desire.'></i>" : number_format($e_slot) ?></b> <span class="text-muted ml-2 fa fa-tag"></span> <b><?= rtrim(number_format($row['economy_fare'],2),'.') ?></b></div>
                                    </td>
                                    <td class="px-1" align="center">
                                        <a href="./?page=reserve&sid=<?= $row['id'] ?>" class="btn btn-flat btn-primary btn-sm" >Book <i class="fa fa-angle-right"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#filter-schedule').submit(function(e){
            e.preventDefault();
            location.href = "./?page=schedules&"+$(this).serialize();
        })
    })
</script>