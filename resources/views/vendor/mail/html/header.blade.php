@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
            @else
                {{--{{ $slot }}--}}
                <img src="{{asset('img/icon/glotzorange.png')}}" class="logo" alt="Glotz" style="width: 170px">
            @endif
        </a>
    </td>
</tr>
