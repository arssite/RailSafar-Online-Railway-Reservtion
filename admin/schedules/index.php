<?php 
$type = isset($_GET['type']) ? $_GET['type'] : 1;
?>
<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">List of Schedules</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New Schedule</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<div class="row my-2">
				<a href="./?page=schedules" class="btn btn-flat col-md-3 text-center <?= $type == 1 ? "btn-primary" : 'btn-light border' ?>"><i class="fa fa-calendar"></i> Daily Schedules</a>
				<a href="./?page=schedules&type=2" class="btn btn-flat col-md-3 text-center <?= $type == 2 ? "btn-primary" : 'btn-light border' ?>"><i class="fa fa-calendar-day"></i> One-Time Schedules</a>
			</div>
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
					<tr>
						<th>Code</th>
						<th>Schedule</th>
						<th>Route</th>
						<th>Train</th>
						<th>Fare/Capacity</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$trains = $conn->query("SELECT *,Concat(code,' - ',`name`) as train FROM `train_list` where id in (SELECT train_id FROM `schedule_list` where delete_flag = 0 and `type` = '{$type}')");
						$res = $trains->fetch_all(MYSQLI_ASSOC);
						$train_fcf_arr = array_column($res,'first_class_capacity','id');
						$train_ef_arr = array_column($res,'economy_capacity','id');
						$train_arr = array_column($res,'train','id');
						$qry = $conn->query("SELECT * from `schedule_list` where delete_flag = 0 and `type` = '{$type}' order by unix_timestamp(`date_created`) asc ");
						while($row = $qry->fetch_assoc()):
							
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
								<div class="px-1 border-bottom"><span class="text-muted">First Class:</span> <span class="text-muted fa fa-user"></span> <b><?= isset($train_fcf_arr[$row['train_id']]) ? $train_fcf_arr[$row['train_id']] : 0 ?></b> <span class="text-muted ml-2 fa fa-tag"></span> <b><?= rtrim(number_format($row['first_class_fare'],2),'.') ?></b></div>
								<div class="px-1"><span class="text-muted">Economy:</span> <span class="text-muted fa fa-user"></span> <b><?= isset($train_ef_arr[$row['train_id']]) ? $train_ef_arr[$row['train_id']] : 0 ?></b> <span class="text-muted ml-2 fa fa-tag"></span> <b><?= rtrim(number_format($row['economy_fare'],2),'.') ?></b></div>
							</td>
							<td class="px-1" align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
        $('#create_new').click(function(){
			uni_modal("Add New Schedule","schedules/manage_schedule.php",'mid-large')
		})
        $('.edit_data').click(function(){
			uni_modal("Update Schedule Details","schedules/manage_schedule.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Schedule permanently?","delete_schedule",[$(this).attr('data-id')])
		})
		$('.view_data').click(function(){
			uni_modal("Schedule Details","schedules/view_schedule.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table td, .table th').addClass('py-1 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_schedule($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_schedule",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>