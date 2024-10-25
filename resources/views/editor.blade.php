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
                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="nameInput" name="name" value="{{ !empty($data->name) ? $data->name : '' }}" maxlength="100">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="professionInput">Profession</span>
                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="professionInput" name="profession" value="{{ !empty($data->profession) ? $data->profession : '' }}" maxlength="100">
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
                                    <img src="data:{{ $data->mime_type }};base64,{{ $data->profile_picture }}" alt="Profile" width="200" height="200">
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
                                                <span style="color: red; display: flex; align-items: center; padding: 0;">*</span>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="skillDescInput">Description</label>
                                                <textarea class="form-control" rows="3" id="skillDescInput" name="desc" required></textarea>
                                                <span style="color: red; display: flex; align-items: center; padding: 0;">*</span>
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
                                        <a href="{{ route('skill.delete', $loop->index) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this skill?')">Delete Skill</a>
                                    @endforeach
                                @else
                                    <p>Really no skills available? you're suck.</p>
                                @endif
                            </li>
                            <li class="list-group-item">
                                {{-- My Projects form--}}
                                <h4>My Projects :</h4>
                                <div class="d-grid mb-3">
                                    <form action="{{ route('projects') }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <!-- Title Input -->
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="projectTitleInput">Title</label>
                                                <input type="text" name="title" id="projectTitleInput" class="form-control" placeholder="Title" required>
                                                <span style="color: red; display: flex; align-items: center; padding: 0;">*</span>
                                            </div>
                                            <!-- Description Input -->
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="projectDescInput">Description</label>
                                                <textarea class="form-control" rows="3" id="projectDescInput" name="desc" required></textarea>
                                                <span style="color: red; display: flex; align-items: center; padding: 0;">*</span>
                                            </div>
                                            <!-- Link Input (Type URL) -->
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="projectLinkInput">Link</label>
                                                <input type="url" name="link" id="projectLinkInput" class="form-control" placeholder="Link to your project" required>
                                                <span style="color: red; display: flex; align-items: center; padding: 0;">*</span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">Add Project</button>
                                    </form>
                                </div>

                                <h6>Your Projects :</h6>
                                @if (!empty($data->projects))
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($data->projects as $project)
                                                <div class="col-md-6 col-lg-4 tablet-lg-top-30">
                                                    <div class="card my-3">
                                                        <div class="card-body p-4">
                                                            <h4 class="pb-2">{{ $project->title }}</h4>
                                                            <p class="pb-3 text-black-50">{{ $project->desc }}</p>
                                                            <a href="{{ $project->link }}" target="_blank" class="btn btn-sm btn-dark mb-1">Link to project</a>
                                                            <a href="{{ route('project.delete', $loop->index) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this project?')">Delete Project</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <p>Really no project you ever worked on? you're suck.</p>
                                @endif
                            </li>
                            <li class="list-group-item">
                                {{-- Contact form--}}
                                <h4>Contacts :</h4>
                                <div class="d-grid mb-3">
                                    <form action="{{ route('contacts') }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="instagramInput">Link to your Instagram</span>
                                            <input type="url" class="form-control" aria-label="Instagram input" aria-describedby="instagramInput" name="instagram" value="{{ !empty($data->contacts->instagram) ? $data->contacts->instagram : '' }}">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="linkedinInput">Link to your LinkedIn</span>
                                            <input type="url" class="form-control" aria-label="LinkedIn input" aria-describedby="linkedinInput" name="linkedin" value="{{ !empty($data->contacts->linkedin) ? $data->contacts->linkedin : '' }}">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="emailInput">Email</span>
                                            <input type="email" class="form-control" aria-label="Email input" aria-describedby="emailInput" name="email" value="{{ !empty($data->contacts->email) ? $data->contacts->email : '' }}">
                                        </div>
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </form>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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
