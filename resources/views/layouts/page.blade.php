<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Academic Fidelity</title>

        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link href = "https://fonts.googleapis.com/css?family=Lato" rel = "stylesheet"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel = "stylesheet" href = "{{ asset('css/all.css') }}" defer></link>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script src = "https://cdn.quilljs.com/1.1.3/quill.min.js"></script>

        <script>
            //Opens modal.
            function openModal() {
                document.getElementById('modal-1').click();
            }

            //Reset current url.
            function resetUrl(replacementUrl) {
                window.app['_router'].replace(replacementUrl);
            }

            //closes modal, resets url.
            function closeModal(replacementUrl) {
                document.getElementById('modalClose').click();
                resetUrl(replacementUrl);
            }
        </script>
    </head>

    <body>
        <div id="app">
            <div id = "header">
                <div>
                    <div>
                        <p id = "title">Academic Fidelity</p>
                    </div>
                </div>
                @guest
                    <table id="links">
                        <tbody>
                        <tr>
                            <th class = "link">
                                <p class = "link underline" onclick = "document.getElementById('aboutCont').classList.remove('fadeIn'); document.getElementById('aboutCont').classList.add('fadeOut')"> Home</p>
                            </th>
                            <th class = "link">
                                <p class = "link underline" onclick = "showAbout()">About</p>
                            </th>
                            <th class = "link">
                                <a class = "link underline" href = "{{ route('login') }}">Log-In</a>
                            </th>
                            <th class = "link">
                                <a class = "link underline" href = "{{ route('register') }}">Register</a>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                @else
                    <table id = "links">
                        <th class = "linkCell">
                            <p id = "name">{{ Auth::user()->name }}</p>
                        </th>
                        <th class = "linkCell">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </th>
                        <th class = "linkCell">
                            <i class="fas fa-sign-out-alt"
                                   onclick = "event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <form id = "logout-form" action = "{{ route('logout') }}" method = "POST" class = "d-none">
                                @csrf
                            </form>
                        </th>
                    </table>
                @endguest
            </div>
            @guest
            @else
                <div class = "wrapper">
                    <nav class = "vertical">
                        <ul>
                            <li>
                                <label for = "home">Classes</label>
                                <input type = "radio" name = "verticalMenu" id = "home">
                                <div>
                                    <class-list ref = "classList"></class-list>
                                </div>
                            </li>
                            <li>
                                <label for = "home">Groups</label>
                                <input type = "radio" name = "verticalMenu" id = "home">
                                <div>
                                    <group-list></group-list>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div id = "mainBox">
                    <label for = "modal-1">Open Modal</label>
                    <input class = "modal-state" id = "modal-1" type = "checkbox">
                    <div class = "modal" id = "modal">
                        <label class = "modal__bg" for = "modal-1"></label>
                        <div class = "modal__inner" id = "modalinner">
                            <label class = "modal__close" for = "modal-1" id = "modalClose"></label>
                            <router-view name = "modalView" :key = "$route.fullPath"></router-view>
                        </div>
                    </div>

                    <router-view name = "navTabView" :key = "$route.fullPath"></router-view>
                    <router-view name = "mainBoxView" :key = "window.app.$route.fullPath"></router-view>
                </div>

            @endguest
            </div>
        </div>
    </body>
</html>
