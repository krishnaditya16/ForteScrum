@if($value == "0")
<div class="badge badge-secondary">Waiting Approval</div>
@elseif($value == "1")
<div class="badge badge-danger">Rejected</div>
@elseif($value == "2")
<div class="badge badge-info">In Progress</div>
@elseif($value == "3")
<div class="badge badge-success">Completed</div>
@elseif($value == "4")
<div class="badge badge-warning">On Hold</div>
@elseif($value == "5")
<div class="badge badge-danger">Cancelled</div>
@endif

