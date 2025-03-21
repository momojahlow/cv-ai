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
    <div class="bg-white rounded-lg p-6 w-[600px] mx-auto">
        <div class="flex gap-4">
            {{-- @dd($curriculum) --}}
            <div class="w-24 h-24 bg-gray-200 rounded-md shrink-0">
                <img src="{{ $curriculum->avatar ?  asset('storage/'.$curriculum->avatar):asset('storage/' . $user->avatar)  }}" alt="Avatar de l'utilisateur" class="w-full h-full object-cover rounded-md">
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
            <span class="w-2 h-6 {{$bgColor}} mr-2"></span> Résumé du CV
        </h2>
        <p class="text-gray-700 mt-2 text-xs">{{ $curriculum->resume ?? 'Aucun résumé disponible' }}</p>
        <h2 class="{{$textColor}} font-bold text-lg flex items-center mt-4">
            <span class="w-2 h-6 {{$bgColor}} mr-2"></span> Formation
        </h2>        
        @foreach ($educations as $education)
            <div class="mt-2 pl-6">
                <p class="text-lg font-bold {{$textColor}}">{{$education->school}} : {{$education->diploma}}</p>
                <p class="text-md font-bold">{{$education->level}} : <span class="text-xs font-semibold">{{$education->type}}</span></p>
                <p class="italic font-semibold">
                    {{$education->start_date->format('Y')}} - {{$education->end_date->format('Y')}}
                </p>
                <p class="italic text-gray-600">{{$education->city}} | {{$education->country}}</p>
                <p class="text-gray-700 text-xs">{{$education->description}}</p>
            </div>
        @endforeach
        <h2 class="text-{{$color}} font-bold text-lg flex items-center mt-4">
            <span class="w-2 h-6 bg-{{$color}} mr-2"></span> Expérience Professionnelle
        </h2>        
        @foreach ($experiences as $experience)
            <div class="mt-2 pl-6">
                {{-- <p class="text-lg font-bold text-teal-700">{{$experience->title}} : {{$experience->company}}</p> --}}
                <p class="text-md font-bold">
                    {{$experience->title}} : <span class="text-xs font-semibold">{{$experience->company}}</span>
                </p>
                <p class="italic font-semibold">
                    {{$experience->start_date->format('m/Y')}} - {{$experience->end_date->format('m/Y')}}
                </p>
                <p class="italic text-gray-600">{{$experience->city}} | {{$experience->country}}</p>
                <p class="text-gray-700 text-xs">{{$experience->description}}</p>
            </div>
        @endforeach
        <h2 class="{{$textColor}} font-bold text-lg flex items-center mt-4">
            <span class="w-2 h-6 bg-{{$color}} mr-2"></span> Langues
        </h2>        
        @foreach ($languages as $language)
            <div class="mt-2 pl-6">
                <p class="text-md font-bold">
                    {{$language->name}} : <span class="text-xs font-semibold">{{$language->level}}</span>
                </p>
                <p class="text-gray-700 text-xs">{{$language->description}}</p>
            </div>
        @endforeach
        @if($hobbies && count($hobbies) > 0)
            <h2 class="{{$textColor}} font-bold text-lg flex items-center mt-4">
                <span class="w-2 h-6 {{$bgColor}} mr-2"></span> Loisirs
            </h2>        
            @foreach ($hobbies as $hobby)
                <div class="mt-2 pl-6">
                    <p class="text-md font-bold">
                        {{$hobby->name}}
                        @if($hobby->description)
                            <span class="text-xs font-semibold">- {{$hobby->description}}</span>
                        @endif
                    </p>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>

