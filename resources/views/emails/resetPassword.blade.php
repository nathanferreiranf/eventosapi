@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => $inscrito['url_evento']])
    <img src="{{ $inscrito['logo_evento'] }}" class="logo">
@endcomponent
@endslot

# Redefinição de senha

Olá {{ $inscrito['name'] }}, recebemos uma solicitação de redefinição de senha.

@component('mail::button', ['url' => $inscrito['url_evento'].'/reset-password/'.$inscrito['id']])
Redefinir senha
@endcomponent

Atenciosamente,<br>
{{ $inscrito['nm_evento'] }}

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        
    @endcomponent
@endslot
@endcomponent
