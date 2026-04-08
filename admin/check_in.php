<?php include('db_connect.php'); ?>
<style>
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        margin-bottom: 20px;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .filter-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 20px;
    }
    .custom-select {
        border-radius: 10px;
        padding: 10px;
        border: 2px solid #e1e1e1;
        transition: all 0.3s;
    }
    .custom-select:focus {
        border-color: #4A90E2;
        box-shadow: 0 0 0 0.2rem rgba(74,144,226,0.25);
    }
    .btn-filter {
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .room-table {
        border-radius: 10px;
        overflow: hidden;
    }
    .room-table thead th {
        background: #f8f9fa;
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        color: #495057;
    }
    .room-table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
        transition: background-color 0.2s;
    }
    .room-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .badge {
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
    }
    .badge-available {
        background-color: #28a745;
        color: white;
    }
    .badge-unavailable {
        background-color: #6c757d;
        color: white;
    }
    .btn-check-in {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s;
        background: #4A90E2;
        border: none;
        color: white;
    }
    .btn-check-in:hover {
        background: #357ABD;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74,144,226,0.2);
    }
    .category-name {
        font-weight: 600;
        color: #495057;
    }
    .room-number {
        font-size: 1.1rem;
        font-weight: 500;
        color: #212529;
    }
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 10px;
        border: 2px solid #e1e1e1;
        padding: 8px 15px;
        margin-left: 10px;
    }
    .dataTables_wrapper .dataTables_length select {
        border-radius: 10px;
        border: 2px solid #e1e1e1;
        padding: 5px 10px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card filter-card">
                <div class="card-body">
                    <form id="filter" class="mb-0">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label class="form-label fw-bold mb-2">Room Category</label>
                                <select class="custom-select w-100" name="category_id">
                                    <option value="all" <?php echo isset($_GET['category_id']) && $_GET['category_id'] == 'all' ? 'selected' : '' ?>>All Categories</option>
                                    <?php 
                                    $cat = $conn->query("SELECT * FROM room_categories order by name asc ");
                                    while($row= $cat->fetch_assoc()) {
                                        $cat_name[$row['id']] = $row['name'];
                                        ?>
                                        <option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['category_id']) && $_GET['category_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button class="btn btn-primary btn-filter w-100">
                                    <i class="fa fa-filter me-2"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table room-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Category</th>
                                    <th>Room Number</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $where = '';
                                if(isset($_GET['category_id']) && !empty($_GET['category_id']) && $_GET['category_id'] != 'all'){
                                    $where .= " where category_id = '".$_GET['category_id']."' ";
                                }
                                if(empty($where))
                                    $where .= " where status = '0' ";
                                else
                                    $where .= " and status = '0' ";
                                $rooms = $conn->query("SELECT * FROM rooms ".$where." order by id asc");
                                while($row=$rooms->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="category-name"><?php echo $cat_name[$row['category_id']] ?></td>
                                    <td class="room-number"><?php echo $row['room'] ?></td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 0): ?>
                                            <span class="badge badge-available">Available</span>
                                        <?php else: ?>
                                            <span class="badge badge-unavailable">Unavailable</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-check-in" type="button" data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-sign-in-alt me-2"></i>Check-in
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
</div>

<script>
$(document).ready(function() {
    // Initialisation de DataTables avec des options personnalisées
    $('.room-table').DataTable({
        "pageLength": 10,
        "responsive": true,
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "language": {
            "search": "Search rooms:",
            "lengthMenu": "Show _MENU_ rooms per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ rooms",
            "emptyTable": "No rooms available"
        }
    });

    // Gestion du check-in
    $('.btn-check-in').click(function(){
        uni_modal("Check In","manage_check_in.php?rid="+$(this).attr("data-id"))
    });

    // Gestion du filtre
    $('#filter').submit(function(e){
        e.preventDefault();
        location.replace('index.php?page=check_in&category_id='+$(this).find('[name="category_id"]').val());
    });

    // Animation des badges
    $('.badge').hover(
        function() { $(this).css('transform', 'scale(1.1)'); },
        function() { $(this).css('transform', 'scale(1)'); }
    );
});
</script>