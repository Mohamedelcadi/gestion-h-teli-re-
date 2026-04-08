<?php 
include('db_connect.php');
?>
<style>
	.custom-menu {
        z-index: 1000;
	    position: absolute;
	    background-color: #ffffff;
	    border: 1px solid #0000001c;
	    border-radius: 5px;
	    padding: 8px;
	    min-width: 13vw;
}
a.custom-menu-list {
    width: 100%;
    display: flex;
    color: #4c4b4b;
    font-weight: 600;
    font-size: 1em;
    padding: 1px 11px;
}
	span.card-icon {
    position: absolute;
    font-size: 3em;
    bottom: .2em;
    color: #ffffff80;
}
.file-item{
	cursor: pointer;
}
a.custom-menu-list:hover,.file-item:hover,.file-item.active {
    background: #80808024;
}
table th,td{
	/*border-left:1px solid gray;*/
}
a.custom-menu-list span.icon{
		width:1em;
		margin-right: 5px
}
.candidate {
    margin: auto;
    width: 23vw;
    padding: 0 10px;
    border-radius: 20px;
    margin-bottom: 1em;
    display: flex;
    border: 3px solid #00000008;
    background: #8080801a;

}
.candidate_name {
    margin: 8px;
    margin-left: 3.4em;
    margin-right: 3em;
    width: 100%;
}
	.img-field {
	    display: flex;
	    height: 8vh;
	    width: 4.3vw;
	    padding: .3em;
	    background: #80808047;
	    border-radius: 50%;
	    position: absolute;
	    left: -.7em;
	    top: -.7em;
	}
	
	.candidate img {
    height: 100%;
    width: 100%;
    margin: auto;
    border-radius: 50%;
}
.vote-field {
    position: absolute;
    right: 0;
    bottom: -.4em;
}
.dashboard-card {
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    margin-bottom: 20px;
}
.dashboard-card:hover {
    transform: translateY(-5px);
}
.card-icon {
    position: absolute;
    font-size: 3em;
    bottom: .2em;
    color: #ffffff80;
}
.stat-card {
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
}
.table-container {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.status-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}
.status-checkin {
    background-color: #28a745;
    color: white;
}
.status-checkout {
    background-color: #dc3545;
    color: white;
}
.custom-table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}
.custom-table td {
    vertical-align: middle;
}
.room-number {
    font-weight: bold;
    color: #495057;
}
.guest-name {
    color: #6c757d;
}
</style>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="dashboard-card bg-info">
                <div class="card-body text-white">
                    <h4><b>Total Bookings</b></h4>
                    <hr>
                    <span class="card-icon"><i class="fa fa-book"></i></span>
                    <h3 class="text-right"><b><?php 
                        $booking = $conn->query("SELECT COUNT(*) as count FROM checked WHERE status != 2")->fetch_assoc();
                        echo $booking['count'];
                    ?></b></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card bg-success">
                <div class="card-body text-white">
                    <h4><b>Check-ins Today</b></h4>
                    <hr>
                    <span class="card-icon"><i class="fa fa-door-open"></i></span>
                    <h3 class="text-right"><b><?php 
                        $checkin = $conn->query("SELECT COUNT(*) as count FROM checked WHERE DATE(date_in) = CURDATE() AND status = 1")->fetch_assoc();
                        echo $checkin['count'];
                    ?></b></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card bg-danger">
                <div class="card-body text-white">
                    <h4><b>Check-outs Today</b></h4>
                    <hr>
                    <span class="card-icon"><i class="fa fa-door-closed"></i></span>
                    <h3 class="text-right"><b><?php 
                        $checkout = $conn->query("SELECT COUNT(*) as count FROM checked WHERE DATE(date_out) = CURDATE() AND status = 2")->fetch_assoc();
                        echo $checkout['count'];
                    ?></b></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card bg-warning">
                <div class="card-body text-white">
                    <h4><b>Available Rooms</b></h4>
                    <hr>
                    <span class="card-icon"><i class="fa fa-bed"></i></span>
                    <h3 class="text-right"><b><?php 
                        $rooms = $conn->query("SELECT COUNT(*) as count FROM rooms WHERE status = 0")->fetch_assoc();
                        echo $rooms['count'];
                    ?></b></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">Recent Check-ins & Check-outs</h4>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary active" id="allBtn">All</button>
                        <button type="button" class="btn btn-outline-success" id="checkinBtn">Check-ins</button>
                        <button type="button" class="btn btn-outline-danger" id="checkoutBtn">Check-outs</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Guest Name</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $checked = $conn->query("SELECT c.*, r.room as room_number, c.name as guest_name 
                                                   FROM checked c 
                                                   INNER JOIN rooms r ON r.id = c.room_id 
                                                   WHERE c.status != 0 
                                                   ORDER BY c.date_in DESC LIMIT 10");
                            while($row = $checked->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="room-number">Room <?php echo $row['room_number'] ?></td>
                                <td class="guest-name"><?php echo $row['guest_name'] ?></td>
                                <td><?php echo date('M d, Y h:i A', strtotime($row['date_in'])) ?></td>
                                <td><?php echo $row['status'] == 2 ? date('M d, Y h:i A', strtotime($row['date_out'])) : 'Pending' ?></td>
                                <td>
                                    <?php if($row['status'] == 1): ?>
                                        <span class="status-badge status-checkin">Checked In</span>
                                    <?php else: ?>
                                        <span class="status-badge status-checkout">Checked Out</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info view-details" data-id="<?php echo $row['id'] ?>">
                                        <i class="fa fa-eye"></i>
                                    </button>
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
$(document).ready(function(){
    // Filtrage des entrées du tableau
    $('#checkinBtn').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('.custom-table tbody tr').hide();
        $('.custom-table tbody tr:has(.status-checkin)').show();
    });
    
    $('#checkoutBtn').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('.custom-table tbody tr').hide();
        $('.custom-table tbody tr:has(.status-checkout)').show();
    });
    
    $('#allBtn').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('.custom-table tbody tr').show();
    });

    // Voir les détails
    $('.view-details').click(function(){
        uni_modal("Reservation Details","view_check_details.php?id="+$(this).attr('data-id'));
    });
});
</script>