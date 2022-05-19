@component('mail::message')
Bonjour {{ $data['username'] }},
<br>
<br>
{{ $data['username_comment'] }} a ajouté un nouveau commentaire sur l'article {{ $data['post_title'] }}

@component('mail::button', ['url' => 'http://laravel_blog.test/posts/' . $data['post_id']])
Voir l'article
@endcomponent

A bientôt.<br>
{{ config('app.name') }}
@endcomponent
