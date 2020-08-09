<!DOCTYPE html>
<html>
<head>
	<title>Chiptranz - My Referrals</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="ref_style.css">
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            
            $(document).ready(function(){
                $('.sidenav').sidenav();
            });
        </script>
        <script>
            function copyToClip() {
                /* Get the text field */
                var copyText = document.getElementById("reflink");

                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /*For mobile devices*/

                /* Copy the text inside the text field */
                document.execCommand("copy");

                /* Alert the copied text */
                alert("Link Copied to clipboard");
                }
        </script>
        

</head>
<body>
	<header>
            <nav>
                <div class="nav-wrapper blue" style="padding: 9px 20px" >
                <a href="#" class="brand-logo"><img src="https://chiptranz.com/chip-assets/images/logos/chiptranz2-logo-with-text1.png" alt="Chiptranz" style="max-height: 50px; box-fit: contain;"></a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="{{'/'}}">Back Home</a></li>
                   
                </ul>
                </div>
                
            </nav>
            <ul class="sidenav" id="mobile-demo">
                <li><a href="#">Back Home</a></li>
            </ul>
        </header>
       
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l6">
                    <div class="card orange darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">Current Rewards</span>
                            <p><span class="values">{{$currentReward}}</span> Naira</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="card blue darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">Lifetime Rewards</span>
                            <p><span class="values">{{$currentReward}}</span> Naira</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l6">
                    <div class="card grey lighten-4">
                        <div class="card-content black-text">
                            <span class="card-title">Referral Code</span>
                            
                            <p><span class="values blue-text">{{ strtoupper($ref_code) }}</span></p>
                            <p><input type="text" value="https://sandbox.chiptranz.com/register?ref={{$ref_code}}" id="reflink" readonly>
                                <button onClick="copyToClip()" class="btn-small blue">Copy Link<i class="material-icons right">content_copy</i></button>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="card blue-grey darken-4">
                        <div class="card-content white-text">
                            <span class="card-title">Note</span>
                            
                            <p>{{$commission}} Naira per referal</p>
                            <div class="divider"></div>
                            <br><br>
                            <p>Referall Rewards are paid every 3 months</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l6">
                    <div class="card orange darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">No. of Referral Code Shared</span>
                            <p><span class="values">{{$totalShared}}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="card green darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">No. of Referral Code Used</span>
                            <p><span class="values">{{$totalReferral}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>