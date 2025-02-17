<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2b8d96;
            padding-bottom: 20px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            color: #2b8d96;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            display: flex;
            align-items: center;
        }
        .section-title::before {
            content: "";
            display: inline-block;
            width: 4px;
            height: 20px;
            background-color: #2b8d96;
            margin-right: 10px;
        }
        .profile-info {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .profile-info p {
            margin: 5px 0;
        }
        .experience-item, .education-item {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .date {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .title {
            font-weight: bold;
            color: #2b8d96;
            margin-bottom: 5px;
        }
        .company, .school {
            font-weight: bold;
        }
        .location {
            color: #666;
            font-style: italic;
        }
        .description {
            margin-top: 8px;
            color: #555;
            font-size: 14px;
        }
        .languages-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .language-item {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }
        .language-name {
            font-weight: bold;
        }
        .language-level {
            color: #2b8d96;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $user->name }}</h1>
        <p>{{ $curriculum->title ?? 'Développeur Web' }}</p>
    </div>

    <div class="section">
        <h2 class="section-title">Informations Personnelles</h2>
        <div class="profile-info">
            <p><strong>Téléphone:</strong> {{ $curriculum->phone ?? '-' }}</p>
            <p><strong>E-mail:</strong> {{ $user->email ?? '-' }}</p>
            <p><strong>Date de naissance:</strong> {{ $curriculum->date_of_birth ? Carbon\Carbon::parse($curriculum->date_of_birth)->format('d/m/Y') : '-' }}</p>
            <p><strong>Nationalité:</strong> {{ $curriculum->nationality ?? '-' }}</p>
            <p><strong>Situation familiale:</strong> {{ $curriculum->family_status ?? '-' }}</p>
            <p><strong>Niveau d'étude:</strong> {{ $curriculum->study_level ?? '-' }}</p>
            <p><strong>Adresse:</strong> {{ $curriculum->address ?? '-' }}</p>
        </div>
    </div>

    @if($curriculum->experiences && count($curriculum->experiences) > 0)
    <div class="section">
        <h2 class="section-title">Expériences Professionnelles</h2>
        @foreach($curriculum->experiences as $experience)
            <div class="experience-item">
                <div class="date">
                    {{ Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                    {{ Carbon\Carbon::parse($experience->end_date)->format('M Y') }}
                </div>
                <div class="title">{{ $experience->title }}</div>
                <div>
                    <span class="company">{{ $experience->company }}</span>
                    <span class="location"> • {{ $experience->location }}</span>
                </div>
                <div class="description">{{ $experience->description }}</div>
            </div>
        @endforeach
    </div>
    @endif

    @if($curriculum->educations && count($curriculum->educations) > 0)
    <div class="section">
        <h2 class="section-title">Formation</h2>
        @foreach($curriculum->educations as $education)
            <div class="education-item">
                <div class="date">
                    {{ Carbon\Carbon::parse($education->start_date)->format('Y') }} - 
                    {{ Carbon\Carbon::parse($education->end_date)->format('Y') }}
                </div>
                <div class="title">{{ $education->diploma }}</div>
                <div class="school">{{ $education->school }}</div>
                <div class="description">{{ $education->description }}</div>
            </div>
        @endforeach
    </div>
    @endif

    @if($curriculum->languages && count($curriculum->languages) > 0)
    <div class="section">
        <h2 class="section-title">Langues</h2>
        <div class="languages-grid">
            @foreach($curriculum->languages as $language)
                <div class="language-item">
                    <span class="language-name">{{ $language->name }}</span>
                    <span class="language-level">{{ $language->level }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</body>
</html>
