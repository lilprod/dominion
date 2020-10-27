@if(count($errors) > 0)
    @foreach($errors->all() as $error)
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ik ik-x"></i>
            </button>
            <span>
                <b> {{$error}}</b> </span>
        </div>
    @endforeach
@endif


@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ik ik-x"></i>
        </button>
        <span>
            <b> {{session('success')}} </b> </span>
    </div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ik ik-x"></i>
        </button>
        <span>
            <b> {{session('error')}} </b> </span>
    </div>
@endif
