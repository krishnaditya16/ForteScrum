@if(!is_null($value))
{!! $value !!}
@elseif(is_null($value))
<div class="badge badge-light"><i class="fas fa-question-circle"></i>&nbsp; Description is empty</div>
@endif
