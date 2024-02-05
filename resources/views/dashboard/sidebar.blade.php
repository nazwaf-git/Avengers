@foreach ($data['listmenu'] as $i => $rows)
    @if($rows['main'] != Null || $rows['main'] != "")
        <li class="nav-item">
            <a data-toggle="collapse" href="#{{ $rows['main'] }}" class="collapsed" aria-expanded="false">
                <i class="fa fa-sliders white_color"></i>
                <p>{{ $rows['main'] }}</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="{{ $rows['main'] }}">
                <ul class="nav nav-collapse">
                    @foreach ($data['listmenu'][$i]['menu'] as $row)
                        <li>
                            <a href="{{ url($row['menu_link']) }}">
                                <span class="sub-item">{{ $row['app_menu'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </li>
    @else
        @foreach ($data['listmenu'][$i]['menu'] as $row)
            <li class="nav-item">
                <a href="{{ url($row['menu_link']) }}">
                    <i class="{{ $row['icon'] }}"></i>
                    <p>{{ $row['app_menu'] }}</p>
                </a>
            </li>
        @endforeach
    @endif
@endforeach
