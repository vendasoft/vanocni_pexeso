<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Game Image</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background: rgba(255,255,255,0.9);
            padding: 40px;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .current-image {
            text-align: center;
            margin-bottom: 30px;
        }

        .current-image img {
            max-width: 300px;
            max-height: 200px;
            border: 3px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background: white;
        }

        input[type="file"]:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            background: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .form-buttons {
            text-align: center;
            margin-top: 30px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .file-info {
            font-size: 14px;
            color: #666;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🖼️ Update Game Image</h1>
        
        <div class="current-image">
            <h3>Current Game Image:</h3>
            <img src="{{ asset('storage/game-image.png') }}" alt="Current game image" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2Y4ZjlmYSIvPjx0ZXh0IHg9IjE1MCIgeT0iMTAwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM2Yzc1N2QiIHRleHQtYW5jaG9yPSJtaWRkbGUiPk5vIGltYWdlIGZvdW5kPC90ZXh0Pjwvc3ZnPg=='">
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('update.image') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="game_image">Select New Game Image:</label>
                <input type="file" 
                       id="game_image" 
                       name="game_image" 
                       accept="image/*" 
                       required>
                <div class="file-info">
                    Supported formats: PNG, JPG, JPEG, GIF. Maximum size: 2MB.
                </div>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn">🔄 Update Image</button>
                <a href="{{ route('pexeso.index') }}" class="btn btn-secondary">🎮 Back to Game</a>
            </div>
        </form>
    </div>
</body>
</html>