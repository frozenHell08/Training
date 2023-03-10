<x-mail::message>
Hello {{ $name }}!<br>

Thank you for registering to this application.<br>
You have registered with the following details : <br>
Name : {{ $name }} <br>
Username : {{ $username }} <br>
<br><br>
Please click the button below to verify your email.

<x-mail::button :url="''">
Verify Email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
