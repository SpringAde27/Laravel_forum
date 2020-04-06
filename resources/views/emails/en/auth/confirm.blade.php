Welcome! {{ $user->name }}
<br>
To verify your subscription, open the following address in your browser.
<br>
{{ route('users.confirm', $user->confirm_code )}}