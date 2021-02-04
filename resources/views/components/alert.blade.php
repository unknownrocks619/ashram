@if($errors->any())
<div class="alert alert-danger alert-dismissible mb-2" role="alert">
    <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
        x
    </button>
    @foreach ($errors->all() as $error)
        <div class='d-flex align-items-center'>
            <i class="bx bx-error"></i>
            <span>{{ $error }}</span>
        </div>
    @endforeach
</div>
@endif