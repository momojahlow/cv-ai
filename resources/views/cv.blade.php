<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 ">
    @php
        $bgColor = 'bg-' . $color;
        $textColor = 'text-' . $color;
        $borderColor = 'border-' . $color.' border-opacity-30';
    @endphp
    <div class="bg-white rounded-lg p-6 max-w-5xl mx-auto">
        <div class="flex gap-4">
            {{-- @dd($curriculum) --}}
            <div class="w-24 h-24 bg-gray-200 rounded-md shrink-0">
                @php
                    $hasAvatar = $curriculum->avatar || ($user->avatar && $user->avatar !== 'default-avatar.png');
                    $initials = substr($user->name, 0, 2);
                @endphp

                @if ($hasAvatar)
                    <img 
                        src="{{ $curriculum->avatar ? asset('storage/'.$curriculum->avatar) : asset('storage/' . $user->avatar) }}" 
                        alt="Avatar de l'utilisateur" 
                        class="w-full h-full object-cover rounded-md"
                    >
                @else
                    <div class="w-full h-full rounded-md flex items-center justify-center bg-gray-300 text-gray-600 text-2xl font-bold uppercase">
                        {{ $initials }}
                    </div>
                @endif
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $user->name }}</h1>
                <p class="text-gray-600">{{ $curriculum->title ?? 'Intitulé du poste' }}</p>
                {{-- <p class="text-xs text-gray-500">{{ $curriculum->title ?? 'Résumé du poste' }}</p> --}}
            </div>
        </div>

        <div class="mt-4 flex justify-between text-sm text-gray-700">
            <div>
                <p>
                    <strong>Date de naissance :</strong>
                    {{ $curriculum->date_of_birth ? $curriculum->date_of_birth->format('d/m/Y') : '-' }}
                </p>
                <p><strong>Nationalité :</strong> {{ $curriculum->nationality ?? '-' }} </p>
                <p><strong>Situation familiale :</strong>{{ $curriculum->family_status ?? '-' }}</p>
            </div>
            <div>
                <p><strong>Niveau d'étude :</strong> {{ $curriculum->study_level ?? '-' }}</p>
                {{-- <p><strong>Expérience :</strong> De 1 à 3 ans</p> --}}
                <p><strong>Disponibilité :</strong> Immédiate</p>
            </div>
        </div>

        <hr class="my-3 {{$borderColor}} border-dotted ">

        <div class="text-sm text-gray-700">
            <p><strong>Adresse :</strong> {{ $curriculum->address ?? '-' }}</p>
            <p><strong>Téléphone :</strong> {{ $curriculum->phone ?? '-' }} | <strong>E-mail :</strong> {{ $curriculum->email ?? '-' }}</p>
        </div>

        <hr class="my-3 {{$borderColor}} border-dotted ">

        <h2 class="{{$textColor}} font-bold text-lg flex items-center">
            <span class="w-2 h-6 {{$bgColor}} mr-2"></span>  Objectif Professionnel
        </h2>
        <p class="text-gray-700 mt-2 text-xs">{{ $curriculum->resume ?? 'Aucun résumé disponible' }}</p>
        <h2 class="{{$textColor}} font-bold text-lg flex items-center mt-4">
            <span class="w-2 h-6 {{$bgColor}} mr-2"></span> Compétences
        </h2> 
        @if($competencies && count($competencies) > 0)  
            <ul class="mt-2 pl-8 space-y-2 list-disc">
                @foreach ($competencies as $competency)
                <li class="text-md font-bold capitalize icon">
                    {{$competency->name}}
                    {{-- @if($competency->description)
                        <span class="text-xs font-semibold text-gray-600"> - {{$competency->description}}</span>
                    @endif --}}
                </li>
                @endforeach
            </ul>           
        @endif
        <h2 class="text-{{$color}} font-bold text-lg flex items-center mt-4">
            <span class="w-2 h-6 bg-{{$color}} mr-2"></span> Expérience Professionnelle
        </h2>        
        @foreach ($experiences as $experience)
            <div class="mt-2 pl-6">
                {{-- <p class="text-lg font-bold text-teal-700">{{$experience->title}} : {{$experience->company}}</p> --}}
                <p class="text-md font-bold">
                    <span> {{$experience->title}} - {{$experience->company}}</span>
                    <span class="text-sm text-gray-600 "> 
                        - {{$experience->start_date->format('m/Y')}} - {{$experience->end_date->format('m/Y')}}
                    </span>
                </p>
                <p class="text-sm text-gray-600">{{$experience->city}} | {{$experience->country}}</p>
                <p class="text-gray-700 text-xs">{{$experience->description}}</p>
            </div>
        @endforeach
        <h2 class="{{$textColor}} font-bold text-lg flex items-center mt-4">
            <span class="w-2 h-6 {{$bgColor}} mr-2"></span> Formation
        </h2>        
        @foreach ($educations as $education)
            <div class="mt-2 pl-6">
                {{-- <p class="text-lg font-bold {{$textColor}}">{{$education->school}} : {{$education->diploma}}</p> --}}
                <p class="text-lg font-bold ">
                    <span>{{$education->diploma}} - {{$education->school}} | </span>
                    <span class="text-sm text-gray-600">{{$education->start_date->format('Y')}} - {{$education->end_date->format('Y')}}</span>
                </p>
                <p class="text-md font-bold text-gray-600">
                    {{$education->level}} | <span class="text-xs">{{$education->type}}</span>
                </p>
                <p class="text-gray-600">{{$education->city}} | {{$education->country}}</p>
                <p class="text-gray-700 text-xs">{{$education->description}}</p>
            </div>
        @endforeach
        
        <h2 class="{{$textColor}} font-bold text-lg flex items-center mt-4">
            <span class="w-2 h-6 bg-{{$color}} mr-2"></span> Langues
        </h2>        
        @foreach ($languages as $language)
            <div class="mt-2 pl-6">
                <p class="text-md font-bold">
                    <span class="uppercase ">{{$language->name}} </span>: <span class="text-xs font-semibold">{{$language->level}}</span>
                </p>
                {{-- <p class="text-gray-700 text-xs">{{$language->description}}</p> --}}
            </div>
        @endforeach

        
        <h2 class="{{$textColor}} font-bold text-lg flex items-center mt-4">
            <span class="w-2 h-6 {{$bgColor}} mr-2"></span> Centres d’intérêt
        </h2>
        @if($hobbies && count($hobbies) > 0)               
            <div class="mt-2 pl-6">
                @foreach ($hobbies as $hobby)
                    <span class="capitalize ">{{$hobby->name}} </span>
                    @if (!$loop->last)
                    |
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>



