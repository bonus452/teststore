@if (session(RESULT_MESSAGE))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session(RESULT_MESSAGE) }}
    </div>
@endif
