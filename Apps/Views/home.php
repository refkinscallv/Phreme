<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title><?= $_SERVER["APP_NAME"] ?> - Simple PHP framework with MVC architecture</title>
    <link rel="shortcut icon" href="<?= $official_url . "images/assets/phreme_favicon.png" ?>">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Remix Icon 4.2.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">

    <!-- Highlight.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>

    <!-- jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>hljs.highlightAll();</script>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");

        *,
        *:after,
        *:before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            scrollbar-width: thin;
            scrollbar-color: #3c7782 var(--bs-white);
        }
        *::-webkit-scrollbar {width: 12px}
        *::-webkit-scrollbar-track {background: var(--bs-white)}
        *::-webkit-scrollbar-thumb {background-color: #3c7782;border: 3px solid var(--bs-white)}

        .selector-for-some-widget {box-sizing: content-box}

        body, html {
            position: relative;
            width: 100%;
            margin: auto;
            font-family: 'Quicksand', sans-serif !important;
            font-size: normal !important;
            color: var(--bs-gray-900)
        }

        a {
            color: #3c7782;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: .3s
        }

        a:hover {
            color: var(--bs-danger);
            text-decoration: none !important
        }

        .full {
            width: 100%;
            margin: auto
        }

        .main-color {
            color: #3c7782 !important;
        }

        .navbar .navbar-nav .nav-item {
            margin-right: 20px
        }

        .navbar .navbar-nav .nav-item:last-child {
            margin-right: 0px
        }

        @media screen and (max-width: 720px){
            .row [class^="col-"] {
                margin-bottom: 20px !important
            }

            .row [class^="col-"]:last-child {
                margin-bottom: 0px !important
            }
        }
    </style>

</head>
<body class="bg-light vh-100 w-100 m-auto overflow-auto position-relative">
    
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a href="<?= $official_url ?>" class="navbar-brand" target="_blank">
                <img src="<?= $official_url .'images/assets/phreme.png' ?>" alt="<?= $app_name ?>" height="25" class="d-inline-block align-text-middle" title="<?= $app_name ?>">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $official_url ?>" target="_blank"><i class="ri-home-line"></i>&nbsp; Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $official_url . 'docs/v1/' ?>" target="_blank"><i class="ri-book-2-line"></i>&nbsp; Docs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $official_url . 'forums/' ?>" target="_blank"><i class="ri-discuss-line"></i>&nbsp; Forum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/refkinscallv/phreme" target="_blank"><i class="ri-github-fill"></i>&nbsp; Contribute</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="my-5">
        <div class="container">
            <h1 class="fw-light mb-3">Welcome to <span class="fw-bold"><?= $app_name ?></span> <?= $version ?></h1>
            <p class="fs-4">PHP framework offers a comprehensive set of features to streamline web development</p>
            <hr>
            <p>Fast configuration, only 3 steps to create cool web pages :</p>
            <p class="mb-5"><i class="ri-sparkling-fill"></i>&nbsp; <b>Create Controller File</b> &nbsp;<i class="ri-arrow-right-s-line"></i>&nbsp; <b>Create View File</b> &nbsp;<i class="ri-arrow-right-s-line"></i>&nbsp; <b>Set Route</b></p>
            <h3 class="fw-light main-color"># Create <b>Controller</b> File</h3>
            <div class="mb-5 ps-4">
                Open the <code class="fw-bold">Apps/Controllers/</code> folder, then create a new file. Example: <code class="fw-bold">Sample.php</code>
<pre>
    <code class="language-php">
        <p>&lt;?php</p>

            <p>namespace Phreme\App\Controller;</p>

            <p>defined(&quot;PHREME&quot;) OR exit(&quot;Forbidden Access&quot;);</p>

            <p>class Sample extends \Phreme\Systems\Controller {</p>

            <p>&nbsp;&nbsp;&nbsp;&nbsp;public function __construct(){</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parent::__construct();</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;}</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;public function index(){</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;load-&gt;view(&quot;sample_view&quot;);</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;}</p>
            <p>}</p>
    </code>
</pre>
            </div>
            <h3 class="fw-light main-color"># Create <b>View</b> File</h3>
            <div class="mb-5 ps-4">
                Next, create a view file, according to the one used in the controller. Open the <code class="fw-bold">Apps/Views/</code> folder, create the <code class="fw-bold">sample_view.php</code> file :
<pre>
    <code class="language-html">
    &lt;!DOCTYPE html&gt;
    &lt;html lang=&quot;en&quot;&gt;
    &lt;head&gt;
        &lt;meta charset=&quot;UTF-8&quot;&gt;
        &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0&quot;&gt;
        &lt;title&gt;You Page&lt;/title&gt;
    &lt;/head&gt;
    &lt;body&gt;
        
    &lt;/body&gt;
    &lt;/html&gt;
    </code>
</pre>
            </div>
            <h3 class="fw-light main-color"># Set <b>Route</b></h3>
            <div class="mb-5 ps-4">
                Last step, set the route by indicating the URL path where your page will be displayed. Open the <code class="fw-bold">Apps/Routes/</code> folder, then open the <code class="fw-bold">Routes.php</code> file
<pre>
    <code class="language-php">
        public function run(): void {
            /**
            * Format to set route for controller
            * 
            * $this-&gt;route-&gt;set(#PATH, #CONTROLLER, #PARAM);
            * 
            * (String) #PATH : To indicate a controller will be used at a specific path in URL
            * (String) #CONTROLLER : A controller class to be used includes the directory where the controller file is located.
            * (Boolean) #PARAM : For permission to use parameters as values in the controller
            */

            $this-&gt;route-&gt;setDefault(&quot;Home@index&quot;, true);

            // Add Your Route Here
            $this-&gt;route-&gt;set(&quot;/sample&quot;, &quot;Sample@index&quot;, true);

            /**
             * '/sample' is the URL path which will bring up the web page that you have created
             * Sample@index : 'Sample' is the class you created previously, and 'index' is the default method for initializing the class
             */

            $this-&gt;route-&gt;run();
        }
    </code>
</pre>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>