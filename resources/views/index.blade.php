<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
              <a class="navbar-brand" href="#">Item Manager</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="{{url('/')}}">Home</a>
                  </li>
              </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h1>Add Item</h1>
                    <form id="item-form">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" id="body"></textarea>
                        </div>
                        <input type="submit" value="Submit" class="btn btn-primary">
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-8 offset-md-2">
                    <h1>Items List</h1>
                    <ul id="items" class="list-group">
                    
                    </ul>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                getItems();

            // submit event
            $('#item-form').on('submit', function(e){
                e.preventDefault();

                let name = $('#name').val();
                let body = $('#body').val();

                addItem(name, body);
            });

            // delete event
            $('body').on('click', '.delete-btn', function(e){
                e.preventDefault();
                let id = $(this).data('id');
                deleteItem(id);
            });

            // delete item through API
            function deleteItem(id){
                $.ajax({
                    method: 'POST',
                    url: 'http://laravel-rest-api.local/api/items/' + id,
                    data: {
                        _method: 'DELETE'
                    }
                }).done(function(item){
                    alert('Item removed!');
                    location.reload();
                });
            }
            // insert items using API
            function addItem(name, body){
                $.ajax({
                    method: 'POST',
                    url: 'http://laravel-rest-api.local/api/items',
                    data: {
                        name: name,
                        body: body
                    }
                }).done(function(item){
                    alert('Item # '+item.id+' added');
                    location.reload();
                });
            }

            // get items from API
              function getItems(){
                $.ajax({
                    url: 'http://laravel-rest-api.local/api/items',
                }).done(function(items){
                    let output = '';
                    $.each(items, function(key, item){
                        output += `
                        <li class="list-group-item">
                        <strong>${item.name}: </strong>${item.body} 
                        <a href="#" class="btn-sm btn-danger delete-btn" data-id="${item.id}">Delete</a>
                        </li>
                        `;
                    });
                    $('#items').append(output);
                });
              }
            });
        </script>
    </body>
</html>
