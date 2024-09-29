<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/icon/x-icon" href="{{ asset('img/icons/person-vcard-fill.svg') }}">
    <title>Editor Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Editor</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                {{-- Menampilkan pesan sukses jika ada --}}
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                {{-- Logout button --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-danger">Logout</button>
                                    </div>
                                </form>
                                {{-- back button --}}
                                <div class="d-grid mb-3">
                                    <a href="{{ route('portofolio page') }}" class="btn btn-success">
                                        Back to portofolio
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                {{-- Profile form --}}
                                <h4>Profile from:</h4>
                                <div class="d-grid mb-3">
                                    <form action="{{ route('profile') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="nameInput">Name</span>
                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="nameInput" name="name" value="{{ !empty($data->name) ? $data->name : '' }}">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="professionInput">Profession</span>
                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="professionInput" name="profession" value="{{ !empty($data->profession) ? $data->profession : '' }}">
                                        </div>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="profile_pictureInput">Profile Picture</label>
                                            <input type="file" class="form-control" id="profile_pictureInput" accept="png, jpeg, jpg, gif" name="profile_picture">
                                        </div>
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </form>                            
                                </div>  
                                {{-- Tampilkan gambar profil jika ada --}}
                                @if (!empty($data->profile_picture))
                                    <h6>Your Profile Picture:</h6>
                                    <img src="data:{{ $data->mime_type }};base64,{{ $data->profile_picture }}" alt="Profile Picture" width="200" height="200">
                                @else
                                    <p>No profile picture available</p>
                                @endif
                            </li>
                            <li class="list-group-item">
                                {{-- About form--}}
                                <h4>About from:</h4>
                            </li>
                            <li class="list-group-item">
                                {{-- Skill form--}}
                                <h4>Skill from:</h4>
                            </li>
                            <li class="list-group-item">
                                {{-- My Projects form--}}
                                <h4>My Projects from:</h4>
                            </li>
                            <li class="list-group-item">
                                {{-- Contact form--}}
                                <h4>Contact from:</h4>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-2HjD8LKo5QIsE5KChjArAxYGVJgPphA3v8N5U1PjM97L0VbFYg9gpNYUBs8LxK5S" crossorigin="anonymous"></script>
</body>
</html>
