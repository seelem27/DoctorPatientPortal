@if(count($errors))
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were problems with input:
        <br></br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif