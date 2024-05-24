<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Reservations</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>Seat #</th>
						<th>Schedule</th>
						<th>Schedule Code</th>
						<th>Passenger</th>
						<th>Group</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT r.*,s.code as sched_code from `reservation_list` r inner join `schedule_list` s on r.schedule_id = s.id order by unix_timestamp(r.`date_created`) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td><?= $row['seat_num'] ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['schedule'])) ?></td>
							<td><?php echo ($row['sched_code']) ?></td>
							<td class=""><p class="truncate-1"><?php echo ucwords($row['lastname'].', '.$row['firstname'].' '.$row['middlename']) ?></p></td>
							<td class="text-center">
								<?php 
									switch ($row['seat_type']){
										case 1:
											echo '<span class="rounded-pill badge badge-warning col-6">First Class</span>';
											break;
										case 2:
											echo '<span class="rounded-pill badge badge-success col-6">Economy</span>';
											break;
									}
								?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-window-restore text-gray"></span> View</a>
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
</div>
<script>
	$(document).ready(function(){
		$('.view_data').click(function(){
			uni_modal("Resevation Details","reservations/view_details.php?id="+$(this).attr('data-id'),"mid-large")
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Reservation permanently?","delete_reservation",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_reservation($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_reservation",
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