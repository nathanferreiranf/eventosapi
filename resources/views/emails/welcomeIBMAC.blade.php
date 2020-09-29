@component('mail::layout')
{{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        
    @endcomponent
@endslot

{{-- Body --}}
<a href="{{ $data->redirect_url }}" style="width: 100%">
    <img src="https://ibmecsummit.com.br/evento-ibemac/public/images/pecas-email/banner.png" alt="Banner">
</a>

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
        © {{ date('Y') }} {{ $data->name_company }}.
    @endcomponent
@endslot
@endcomponent
