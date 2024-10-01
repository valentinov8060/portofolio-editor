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
                                <h4>Profile :</h4>
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
                                            <input type="file" class="form-control" id="profile_pictureInput" accept=".png, .jpeg, .jpg, .gif" name="profile_picture" onchange="checkFileSize(this)">
                                        </div>
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </form>                            
                                </div>  
                                {{-- Tampilkan gambar profil jika ada --}}
                                <h6>Your Profile Picture :</h6>
                                @if (!empty($data->profile_picture))
                                    <img src="data:{{ $data->mime_type }};base64,{{ $data->profile_picture }}" alt="Profile Picture" width="200" height="200">
                                @else
                                    <p>No profile picture available</p>
                                @endif
                            </li>
                            <li class="list-group-item">
                                {{-- About form--}}
                                <h4>About :</h4>
                                <form action="{{ route('about') }}" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <textarea class="form-control" rows="3" id="aboutInput" name="about">{{ !empty($data->about) ? $data->about : '' }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </form>
                                
                            </li>
                            <li class="list-group-item">
                                {{-- Skill form--}}
                                <h4>Skills :</h4>
                                <div class="d-grid mb-3">
                                    <form action="{{ route('skills') }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="skillTitleInput">Title</label>
                                                <input type="text" name="title" id="skillTitleInput" class="form-control" placeholder="Title" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="skillDescInput">Description</label>
                                                <textarea class="form-control" rows="3" id="skillDescInput" name="desc" required></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">Add Skill</button>
                                    </form>
                                </div>

                                <h6>Your Skills :</h6>
                                @if(!empty($data->skills))
                                    @foreach($data->skills as $skill)
                                        <div class="col-xl-12 aos-init aos-animate">
                                            <div class="p-4 text-center nn">
                                                <h5 class="pb-2 ls-2">{{ $skill->title }}</h5>
                                                <p class="text-body-tertiary">{{ $skill->desc }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('skills.delete', $loop->index) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this skill?')">Delete Skill</a>
                                    @endforeach
                                @else
                                    <p>Really no skills available? you're suck.</p>
                                @endif
                            </li>
                            <li class="list-group-item">
                                {{-- My Projects form--}}
                                <h4>My Projects :</h4>
                            </li>
                            <li class="list-group-item">
                                {{-- Contact form--}}
                                <h4>Contacts :</h4>
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
    <script>
        function checkFileSize(input) {
            var file = input.files[0];
            var sizeInBytes = file.size;
            var maxSize = 2 * 1024 * 1024; // 2 MB in bytes
        
            if (sizeInBytes > maxSize) {
                alert("Image size cannot exceed 2 MB.");
                input.value = ""; // Clear the file input
            }
        }
    </script>
</body>
</html>
