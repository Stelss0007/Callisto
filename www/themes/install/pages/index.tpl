<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Neon Admin Panel"/>
    <meta name="author" content="Laborator.co"/>
    {appCssOutput cache=0}
</head>
<body class="page-body install-page install-form-fall" data-url="http://demo.neontheme.com">
<div class="install-container">
    <div class="install-header install-caret">
        <div class="install-content">
            <h1 class="white">Callisto CMS</h1>
            <p class="description">
                Dear user, log in to access the admin area!
            </p>
        </div>
    </div>
    <div class="install-progressbar">
        <div></div>
    </div>
    <div class="install-form">
        <div class="install-content">

            <form id="install-form" method="post" action="" class="form-wizard" novalidate="novalidate">
                <div class="steps-progress" style="margin-left: 10%; margin-right: 10%;">
                    <div class="progress-indicator" style="width: 0%;"></div>
                </div>
                <ul>
                    <li class="active">
                        <a href="#tab2-1" data-toggle="tab" aria-expanded="false">
                            <span>1</span>Personal Info
                        </a>
                    </li>
                    <li class="">
                        <a href="#tab2-2" data-toggle="tab" aria-expanded="true">
                            <span>2</span>Address
                        </a>
                    </li>
                    <li class="">
                        <a href="#tab2-3" data-toggle="tab" aria-expanded="false">
                            <span>3</span>Education
                        </a>
                    </li>
                    <li class="">
                        <a href="#tab2-4" data-toggle="tab" aria-expanded="false">
                            <span>4</span>Work Experience
                        </a>
                    </li>
                    <li class="">
                        <a href="#tab2-5" data-toggle="tab" aria-expanded="false">
                            <span>5</span>Register
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane" id="tab1">
                        1
                    </div>
                    <div class="tab-pane" id="tab2">
                        <p>
                            <input type='text' name='name' id='name' placeholder='Enter Your Name'>
                        </p>
                    </div>
                    <div class="tab-pane" id="tab3">
                        3
                    </div>
                    <div class="tab-pane" id="tab4">
                        4
                    </div>
                    <div class="tab-pane" id="tab5">
                        5
                    </div>

                    <ul class="pager wizard">
                        <li class="previous first" style="display:none;"><a href="#">First</a></li>
                        <li class="previous"><a href="#">Previous</a></li>
                        <li class="next last" style="display:none;"><a href="#">Last</a></li>
                        <li class="next"><a href="#">Next</a></li>
                    </ul>
                </div>
            </form>

            <div class="install-bottom-links">
                <a href="http://demo.neontheme.com/extra/forgot-password/" class="link">
                    Forgot your password?
                </a>
                <br/>
                <a href="#">ToS</a> - <a href="#">Privacy Policy</a>
            </div>
        </div>
    </div>
</div>
<script src="/themes/admin/js/jquery-1.11.0.min.js"></script>
<script src="/themes/admin/js/bootstrap.js"></script>
<script src="/themes/install/js/main.js"></script>
</body>
</html>