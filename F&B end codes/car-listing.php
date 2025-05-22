<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Car Lists</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red"
        media="all" data-default-color="true" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css"
        title="orange" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue"
        media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink"
        media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css"
        title="green" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css"
        title="purple" media="all" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed"
        href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <style>
        .chat-button {
            position: fixed;
            bottom: 101px;
            right: 30px;
            background-color: rgb(255, 0, 0);
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            text-align: center;
            line-height: 60px;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease;
        }

        .chat-button:hover {
            background-color: rgb(235, 94, 94);
        }

        .chat-box {
            display: none;
            position: fixed;
            bottom: 90px;
            right: 30px;
            width: 300px;
            max-width: 90%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border: 1px solid #ddd;
            flex-direction: column;
        }

        .chat-box .chat-header {
            padding: 10px;
            background-color: rgb(244, 0, 0);
            color: white;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-box .chat-header button {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .chat-box .chat-body {
            padding: 10px;
            height: 200px;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
        }

        .chat-box .chat-footer {
            display: flex;
            padding: 10px;
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
        }

        .chat-box .chat-footer input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .chat-box .chat-footer button {
            margin-left: 10px;
            padding: 8px 12px;
            background-color: rgb(255, 0, 0);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include('includes/colorswitcher.php'); ?>
    <?php include('includes/header.php'); ?>
    <section class="page-header listing_page">
        <div class="container">
            <div class="page-header_wrap">
                <div class="page-heading">
                </div>
                <ul class="coustom-breadcrumb">
                </ul>
            </div>
        </div>
        <div class="dark-overlay"></div>
    </section>
    <section class="listing-page">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-push-3">
                    <div class="result-sorting-wrapper">
                        <div class="sorting-count">
                            <?php
                            //Query for Listing count
                            $sql = "SELECT id from tblvehicles";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = $query->rowCount();
                            ?>
                            <p><span><?php echo htmlentities($cnt); ?> Listings</span></p>
                        </div>
                    </div>

                    <?php $sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {  ?>
                            <div class="product-listing-m gray-bg">
                                <div class="product-listing-img"><img
                                        src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>"
                                        class="img-responsive" alt="Image" /> </a>
                                </div>
                                <div class="product-listing-content">
                                    <h5><a
                                            href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?>
                                            , <?php echo htmlentities($result->VehiclesTitle); ?></a></h5>
                                    <p class="list-price">$<?php echo htmlentities($result->PricePerDay); ?> Per Day</p>
                                    <ul>
                                        <li><i class="fa fa-user"
                                                aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?>
                                            seats</li>
                                        <li><i class="fa fa-calendar"
                                                aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?> model
                                        </li>
                                        <li><i class="fa fa-car"
                                                aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
                                    </ul>
                                    <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"
                                        class="btn">View Details <span class="angle_arrow"><i
                                                class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>

                <aside class="col-md-3 col-md-pull-9">
                    <div class="sidebar_widget">
                        <div class="widget_heading">
                            <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car </h5>
                        </div>
                        <div class="sidebar_filter">
                            <form action="search-carresult.php" method="post">
                                <div class="form-group select">
                                    <select class="form-control" name="brand">
                                        <option>Select Brand</option>
                                        <?php $sql = "SELECT * from  tblbrands ";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {  ?>
                                                <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group select">
                                    <select class="form-control" name="fueltype">
                                        <option>Select Fuel Type</option>
                                        <option value="Petrol">Petrol</option>
                                        <option value="Diesel">Diesel</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block"><i class="fa fa-search"
                                            aria-hidden="true"></i> Search Car</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="sidebar_widget">
                        <div class="widget_heading">
                            <h5><i class="fa fa-car" aria-hidden="true"></i> Recently Listed Cars</h5>
                        </div>
                        <div class="recent_addedcars">
                            <ul>
                                <?php $sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand order by id desc limit 4";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {  ?>
                                        <li class="gray-bg">
                                            <div class="recent_post_img"> <a
                                                    href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><img
                                                        src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>"
                                                        alt="image"></a> </div>
                                            <div class="recent_post_title"> <a
                                                    href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?>
                                                    , <?php echo htmlentities($result->VehiclesTitle); ?></a>
                                                <p class="widget_price">$<?php echo htmlentities($result->PricePerDay); ?>
                                                    Per Day</p>
                                            </div>
                                        </li>
                                <?php }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </aside>
                </div>
        </div>
    </section>
    <!-- <?php include('includes/footer.php'); ?>
    <div class="chat-button" onclick="toggleChat()">
        <i class="fa fa-comment"></i>
    </div> -->
    <!-- <div id="chat-box" class="chat-box">
        <h6>Chatbot powered by Gemini</h6>
        <div id="chatbox"></div>
        <form id="chat-form">
            <input type="text" id="user-input" placeholder="Type your message..." required />
            <button type="submit">Send</button>
        </form>
    </div>
    <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
    <?php include('includes/login.php'); ?>
    <?php include('includes/registration.php'); ?>
    <?php include('includes/forgotpassword.php'); ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <script src="assets/switcher/js/switcher.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script>
        function toggleChat() {
            var chatBox = document.getElementById("chat-box");
            if (chatBox.style.display === "none" || chatBox.style.display === "") {
                chatBox.style.display = "flex";
            } else {
                chatBox.style.display = "none";
            }
        }

        const form = document.getElementById('chat-form');
        const input = document.getElementById('user-input');
        const chatbox = document.getElementById('chatbox');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const userMessage = input.value.trim();
            if (!userMessage) return;

            appendMessage(userMessage, 'user');
            input.value = '';

            const botReply = await sendMessageToServer(userMessage);
            appendMessage(botReply, 'bot');
            chatbox.scrollTop = chatbox.scrollHeight;
        });

        function appendMessage(text, sender) {
            const msgDiv = document.createElement('div');
            msgDiv.classList.add('message', sender);
            msgDiv.textContent = text;
            chatbox.appendChild(msgDiv);
            chatbox.scrollTop = chatbox.scrollHeight;
        }

        async function sendMessageToServer(message) {
            const response = await fetch('real_api.php', {  // Ensure the path to real_api.php is correct
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `message=${encodeURIComponent(message)}`
            });
            const data = await response.json();
            return data.reply || "No reply from server.";
        }
    </script> -->
</body>

</html>
