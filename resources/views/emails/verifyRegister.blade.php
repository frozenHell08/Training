<x-mail::message>
Hello {{ $name }}!<br>

Thank you for registering to this application.<br>
You have registered with the following details : <br>
Name : {{ $name }} <br>
Username : {{ $username }} <br>
<br>
Please click the button below to verify your email.

<x-mail::button :url="'http://localhost:8000/dashboard'">
Verify Email
</x-mail::button>

Thanks,<br>
OJT Dev Team
</x-mail::message>
