<h1>This is Elqouent Test Blade</h1>

<ul>
    @foreach ($view_data as $key => $view)
        <li> {{ $view->id }} :: {{ $view->name }} </li>
            @if ($view->getRoom != null)
                <p>
                    Room Name ::              
                    @foreach ($view->getRoom as $key => $room)
                        {{ $room->name }} 
                    @endforeach
                </p>
            @endif
        <hr>
    @endforeach
</ul>
