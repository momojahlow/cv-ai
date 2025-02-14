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
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .education-item {
            margin-bottom: 15px;
        }
        .education-date {
            color: #666;
            font-size: 14px;
        }
        .education-school {
            font-weight: bold;
        }
        .education-diploma {
            color: #2b8d96;
        }
        .education-description {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
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
            <p><strong>Date de naissance:</strong> {{ $curriculum->birth_date ?? '' }}</p>
            <p><strong>Nationalité:</strong> {{ $curriculum->nationality ?? '' }}</p>
            <p><strong>Situation familiale:</strong> {{ $curriculum->family_status ?? '' }}</p>
            <p><strong>Niveau d'étude:</strong> {{ $curriculum->education_level ?? '' }}</p>
            <p><strong>Adresse:</strong> {{ $curriculum->address ?? '' }}</p>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Résumé</h2>
        <p>{{ $curriculum->summary ?? '' }}</p>
    </div>

    <div class="section">
        <h2 class="section-title">Formation</h2>
        @foreach($formations as $education)
            <div class="education-item">
                <div class="education-date">{{ $education['startDate'] }} - {{ $education['endDate'] }}</div>
                <div class="education-school">{{ $education['school'] }}</div>
                <div class="education-diploma">{{ $education['diploma'] }}</div>
                <div class="education-description">{{ $education['description'] }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>