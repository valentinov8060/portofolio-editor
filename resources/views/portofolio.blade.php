<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/icon/x-icon" href="{{ asset('img/icons/person-vcard-fill.svg') }}">
    {{-- $data->name --}}
    <title>
        @if (!empty($data->name))
            {{ $data->name }}
        @else
            ...
        @endif
    </title>

    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="{{ asset('css/simple-lightbox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top vv">
        <div class="container">
            {{-- $data->name --}}
            <a class="navbar-brand fw-bolder" href="{{ route('login page') }}">
                @if (!empty($data->name))
                    {{ $data->name }}
                @else
                    ...
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse primary-navigation" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!---------------------------------------Navigation ends here---------------------------------------->

    <section id="home" class="page-section">
        <div class="text-center mm">
            <div class="pb-3">
                {{-- $data->profile_picture --}}
                @if (!empty($data->profile_picture))
                    <img src="data:{{ $data->mime_type }};base64,{{ $data->profile_picture }}" class="profile-pic">
                @else
                    <img src="..." class="profile-pic">
                @endif
            </div>
            <h5 class="text-body-tertiary mb-0">Hi There, I'm</h5>
            {{-- $data->name --}}
            <h3 class="display-2 fw-bold">
                @if (!empty($data->name))
                    {{ $data->name }}
                @else
                    ...
                @endif
            </h3>
            <h3 class="fw-medium text-muted">
                {{-- $data->profession --}}
                <span class="typewrite" data-period="2500" data-type='[ "
                    @if (!empty($data->profession))
                        {{ $data->profession }}
                    @else
                        ...
                    @endif
                " ]'>
                    <span class="wrap"></span>
                </span>
            </h3>
        </div>
    </section>
    <!------------Top banner ends here--------------------->

    <section id="about" class="page-section">
        <div class="mm2">
            <div class="text-center">
                <h3 class="text-uppercase fw-900 display-4 pb-5">About</h3>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="nn p-4 text-center">
                            <h5 class="box-title pb-4">About me</h5>
                            {{-- $data->about --}}
                            <p class="lead text-black-50">
                                @if (!empty($data->about))
                                    {{ $data->about }}
                                @else
                                    ...
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!---------------------About section ends here----------------------------->

    <section id="services" class="page-section">
        <div class="mm2">
            <div class="text-center">
                <h3 class="text-uppercase fw-900 display-4 pb-4">Skills</h3>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 aos-init aos-animate">
                        <div class="p-4 text-center nn">
                            {{-- $data->skill->title --}}
                            <h5 class="pb-2 ls-2">Currently I Learning</h5>
                            {{-- $data->skill->description --}}
                            <p class="text-body-tertiary">
                                HTML, CSS, JavaScript, TypeScript,
                                Bootstrap, Node.js, Express, MySQL, MongoDB, React, React Native, A-Frame, Laravel,
                                Next.js,
                                Jest, Supertest, Git
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ------------------------------Skills section ends here------------------------------- -->

    <section id="portfolio" class="page-section">
        <div class="mm2">
            <div class="text-center">
                <h3 class="text-uppercase fw-900 display-4 pb-5">My Projects</h3>
            </div>

            <div class="container">
                <div class="row">

                    <div class="col-md-6 col-lg-4 tablet-lg-top-30">
                        <div class="card my-3">
                            {{-- $data->project->image --}}
                            <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/vuejs/vuejs-original-wordmark.svg" class="card-img-top" alt="..." height="200" >
                            <div class="card-body p-4">
                                {{-- $data->project->title --}}
                                <h4 class="pb-2">react-native-schedule-app</h4>
                                {{-- $data->project->desc --}}
                                <p class="pb-3 text-black-50">
                                    An application created to record student class schedules. Built with React Native
                                    and SQLite. The backend was developed with Express and MySQL. The backend code is
                                    available in the <a href="https://github.com/valentinov8060/schedule-app"
                                        target="_blank">schedule-app</a> repository.
                                </p>
                                {{-- $data->project->link --}}
                                <a href="https://github.com/valentinov8060/react-native-schedule-app" target="_blank"
                                    class="btn btn-sm btn-dark">Link to project</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- ----------------------------Portfolio section ends here------------------------ -->

    <section id="contact" class="page-section">
        <div class="mm2">
            <div class="text-center">
                <h3 class="text-uppercase fw-900 display-4 pb-2">Get In Touch</h3>
            </div>
            <div class="text-center">
                <p class="lead">Please contact me :)</p>
            </div>
            <div class="container text-center">
                <div class="row justify-content-md-center">
                    {{-- $data->contact->linkedin --}}
                    <div class="col-md-6 col-xl-4 aos-init aos-animate mb-3">
                        <a href="https://www.linkedin.com/in/bill-valentinov-42a8a4250/" target="_blank"
                            class="btn btn-outline-primary py-3 px-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                            </svg>
                            <span class="ps-2">Linkedin</span>
                        </a>
                    </div>

                    {{-- $data->contact->instagram --}}
                    <div class="col-md-6 col-xl-4 aos-init aos-animate mb-3">
                        <a href="https://www.instagram.com/valentinov8060/" target="_blank"
                            class="btn btn-outline-dark py-3 px-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                            </svg>
                            <span class="ps-2">Instagram</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ----------------------------Contact section ends here------------------------ -->

    <footer class="bg-dark">
        <div class="container">
            <div class="row py-5">
                {{-- $data->contact->email --}}
                <div class="col-lg-4">
                    <ul class="list-unstyled text-white pt-2 mb-0">
                        <li class="py-1 d-flex align-items-center">
                            <a href="mailto:valentinovbill0@gmail" target="_blank" rel="noreferrer"
                                class="link-light d-flex align-items-center">
                                <i class="lni lni-envelope"></i>
                                <span class="ps-2">
                                    valentinovbill0@gmail.com
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <p class="text-white pt-3 mb-0 d-flex align-items-center">
                        <span class="pe-2">I Would Love to Work With You</span>
                        <i class="lni lni-heart"></i>
                    </p>
                </div>
            </div>
            <div class="row border-top pb-5">
                <div class="col-lg-6">
                    <p class="mt-3 mb-0 text-white d-lg-inline-block text-center">Template has been designed by
                        <a class="link-light" href="https://bootstraplily.com/" target="_blank">Bootstraplily</a>
                    </p>
                </div>
                <div class="col-lg-6 text-lg-end text-center">
                    <a href="#home" class="mt-3 d-inline-block text-white">Back To Top</a>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kingstudio.ro/demos/mipo/assets/js/typewriter.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/simple-lightbox.jquery.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
