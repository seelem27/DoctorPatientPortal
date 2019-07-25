<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="hold-transition fixed skin-blue">
    <div class="wrapper">
        @include('partials.header')
    </div>

    {{-- <div class="clearfix"></div> --}}

    <aside class="main-sidebar">
        <section class="sidebar" style="height: auto;">
            @include('partials.sidebar')
        </section>
    </aside>
        
        
    <div class="content-wrapper">
        <section class="content-header">  
            @if(isset($siteTitle))
                <h3 class="content-header">
                    {{ $siteTitle }}
                </h3>
            @endif
        
            <div class="row">
                <div class="col-md-12"> 
                    @if (Session::has('message'))
                        <div class="note note-info">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif
                    @if ($errors->count() > 0)
                        <div class="note note-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <section class="content container-fluid">  
            @yield('content')
        </section>
    </div>        

    {!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
        <button type="submit">Logout</button>
    {!! Form::close() !!}

    @include('partials.javascripts')
</body>
</html>