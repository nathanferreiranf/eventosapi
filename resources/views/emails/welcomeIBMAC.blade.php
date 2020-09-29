@component('mail::layout')
{{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        Header Title
    @endcomponent
@endslot

{{-- Body --}}
<table class="corpo-email-banner">
    <tbody>
        <tr>
            <td>
                <a href="{{ $data->redirect_url }}" style="width: 100%">
                    <img src="https://ibmecsummit.com.br/evento-ibemac/public/images/pecas-email/banner.png" alt="Banner">
                </a>
            </td>
        </tr>
    </tbody>
</table>

{{-- Subcopy --}}
@isset($subcopy)
    @slot('subcopy')
        @component('mail::subcopy')
            teste de subcopy
        @endcomponent
    @endslot
@endisset

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. Super FOOTER!
    @endcomponent
@endslot
@endcomponent
