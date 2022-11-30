@component('mail::message')
{{-- Greeting --}}
{{$user->name}} 様

{{-- Intro Lines --}}
{{ config('app.name') }}をご利用いただきありがとうございます。<br />
この度、{{$user->name}} 様のアカウントが発行されましたのでお知らせいたします。<br />

@component('mail::panel')
メールアドレス： {{$user->email}}<br />
パスワード： {{$raw_password}}
@endcomponent

{{-- Action Button --}}
@component('mail::button', ['url' => config('const.FFRONTEND_URL'), 'color' => 'primary'])
ログインはこちら
@endcomponent

{{-- Outro Lines --}}
なお、このメールの内容に覚えがない場合は、その旨をお書き添えの上、以下のメールアドレス宛てにご連絡ください。<br />
<br />
お問い合わせ先／ <a href="mailto:{{config('const.HELP_MAIL_ADDRESS')}}">{{config('const.HELP_MAIL_ADDRESS')}}</a>

{{-- Subcopy --}}
@slot('subcopy')
もし、「ログインはこちら」ボタンがうまく機能しない場合は、以下のURLをブラウザのURL欄にコピー&ペーストしてアクセスして下さい。
<a href="{{config('const.FFRONTEND_URL')}}">{{config('const.FFRONTEND_URL')}}</a>
@endslot
@endcomponent
