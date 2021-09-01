<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"> -->
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Patient</title>
</head>
<body>
    <div class="text-center">
       <h2>
            {{env('APP_NAME')}}
       </h2>
    </div>
    <div class="text-left">
       <strong>Patient Name: </strong> <span> {{ $patient->fullname }}</span> <br/>
       <strong>Birthday: </strong> <span> {{ $patient->birthday }}</span>
       <strong>Sex: </strong> <span> {{ $patient->sex }}</span> <br/>
       <strong>Contact Number: </strong> <span> {{ $patient->contact_number }}</span> <br/>
       <strong>Landline: </strong> <span> {{ $patient->landline }}</span> <br/>
       <strong>Email: </strong> <span> {{ $patient->email }}</span> <br/>
       <strong>Address: </strong> <address> {{ $patient->address }}</address> <br/>
    </div>

    <br>
    <h3 class="text-center"> Consultations </h3>
    @foreach ($consultations as $consultation)
        <div class="container">
            <div>
                <strong>Consulted last:</strong> {{$consultation->created_at}}  - by Doctor {{$consultation->user->fullname}}
            </div>
            <div class="row">
                <div class="col-md-1">
                    <strong>Temperature: </strong> <span>{{$consultation->temperature}}</span>
                </div>

                <div class="col-md-1">
                    <strong>Blood Pressure: </strong> <span>{{$consultation->blood_pressure}}</span>
                </div>

                <div class="col-md-1">
                    <strong>weight: </strong> <span>{{$consultation->weight}}</span>
                </div>

                <div class="col-md-1">
                    <strong>height: </strong> <span>{{$consultation->height}}</span>
                </div>
            </div>

            <strong>findings: </strong> <span>{{$consultation->findings}}</span><br>
            <strong>prescription: </strong> <span>{{$consultation->prescription}}</span><br>
            <strong>recommendation: </strong> <span>{{$consultation->recommendation}}</span><br>

        </div>
        <br/>
    @endforeach
</body>
</html>
