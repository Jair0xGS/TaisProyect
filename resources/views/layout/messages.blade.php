
@if(session('success'))
    <div class="container">
        <div class="alert alert-success mt-4">
            {{session('success')}}
        </div>
    </div>
@endif



@if(session('error'))
    <div class="container">
        <div class="alert alert-danger mt-4">
            {{session('error')}}
        </div>

    </div>
@endif
