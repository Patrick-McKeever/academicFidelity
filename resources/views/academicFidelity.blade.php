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
        //Opens modal, loads given url into modal.
        //If push is 1, router pushes, else replace.
        function openModal(url, push) {
            push ?
                Vue.prototype.$modalApp.$router.push(url) :
                Vue.prototype.$modalApp.$router.replace(url);
            document.getElementById('modal-1').click();
        }

        //closes modal, resets url.
        function closeModal(replacementUrl) {
            document.getElementById('modalClose').click();
            Vue.prototype.$modalApp.$router.replace(replacementUrl);
        }


        //this is just UI.
        function toggle(element) {
            var active = document.getElementsByClassName('activeOn')[0];
            if(active !== undefined){
                active.classList.add('activeOff');
                active.classList.remove('activeOn');
            }
            element.classList.add('activeOn');
            element.classList.remove('activeOff');
        }

        function showAbout() {
            var aboutCont = document.getElementById('aboutCont');
            aboutCont.classList.add('fadeIn');
            aboutCont.classList.remove('fadeOut');
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
                    <a href = "evaluationPortal" target = "_blank">
                        <i class = "fas fa-chalkboard-teacher"></i>
                    </a>
                </th>
                <th class = "linkCell">
                    <i class = "fas fa-sign-out-alt"
                       onclick = "event.preventDefault();
                                        document.getElementById('logout-form').submit();"/>
                        <form id = "logout-form" action = "{{ route('logout') }}" method = "POST" class = "d-none">
                            @csrf
                        </form>
                </th>
            </table>
        @endguest
    </div>
    @guest
        <div id="screen1">
            <div id="filter">
                <div id="descTable">
                    <div id="descCell">
                        <i id="description"> Student Learning Progress Tracking </i>
                        <div id="aboutCont">
                            <p id="about">"Academic Fidelity" is a multimedia data analysis service for teacher accountability and student learning.  This website will track the learning of each student per class, track the student learning goals for verification for evaluation, student improvement, teacher improvement, professional development and increased proficiency.  The students’ proficiency will be based upon the national, state, district and school curriculum standards and objectives.  Teachers, administrators, parents and community leaders will have access to verify student proficiency.  Data Analysis for project based learning, student learning goals for verification for discovery, research, teamwork, creativity for evaluations, student improvement, teacher improvement, professional development and increase proficiency and knowledge.</p>
                        </div>
                    </div>
                </div>
            </div>
            <img src = "images/homePic.jpg" id = "homePic">
        </div>
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
                            <group-list ref = "groupList"></group-list>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div id = "mainBox">
            <router-view name = "navTabView" :key = "$route.fullPath" ref = "navTab"></router-view>
        </div>

    @endguest
</div>

<input class = "modal-state" id = "modal-1" type = "checkbox">
<div class = "modal" id = "modal">
    <label class = "modal__bg" for = "modal-1"></label>
    <div class = "modal__inner" id = "modalinner">
        <label class = "modal__close" for = "modal-1" id = "modalClose"></label>
        <router-view name = "modalView" :key = "$route.fullPath"></router-view>
    </div>
</div>
</body>
</html>
