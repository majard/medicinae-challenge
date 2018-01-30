# medicinae-challenge
An app written in php/Laravel to store information about health insurance companies and clinics. Also includes a simple RESTful api. The fields for registration (at /api/register) are email, name, password and password confirmation. You must be logged in to view/update the resources or create a new one. The api expects a api_token field in your request, that is returned to the client after succesful login (/api/login) or registration. The header should include an Authorization key with value {"Bearer " + api_token} for the current user (without quotation marks or brackets).
Temporarily hosted at http://laravel-q1f8.frb.io for demonstration purposes.